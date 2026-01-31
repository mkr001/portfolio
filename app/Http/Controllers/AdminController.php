<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Contact;
use App\Models\Callback;
use App\Models\Project;
use App\Models\JobApplication;
use App\Models\BusinessInquiry;
use App\Models\FreelanceInquiry;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function login()
    {
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        $password = env('ADMIN_PASSWORD', 'admin123');
        if ($request->password === $password) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('error', 'Invalid password.');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('home');
    }


    public function index()
    {
        // Increased cache to 10 minutes (600s) for faster page loads
        $stats = Cache::remember('admin_dashboard_stats', 600, function () {
            return [
                'contacts' => Contact::count(),
                'callbacks' => Callback::count(),
                'projects' => Project::count(),
                'applications' => JobApplication::count(),
                'business_inquiries' => BusinessInquiry::count(),
                'freelance_inquiries' => FreelanceInquiry::count(),
                'users' => User::count(),
                'feedbacks' => Feedback::count(),
                'unread_chats' => ChatMessage::where('is_from_admin', false)->where('is_read', false)->count(),
                'total_donations' => Setting::get('total_donations', 0),
            ];
        });
        
        // Increased recent items cache to 2 minutes
        $recentContacts = Cache::remember('admin_recent_contacts', 120, function () {
            return Contact::latest()->take(5)->get();
        });

        $recentCallbacks = Cache::remember('admin_recent_callbacks', 120, function () {
            return Callback::latest()->take(5)->get();
        });

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentCallbacks'));
    }


    public function contacts()
    {
        // Cache contacts list for 30s
        $contacts = Cache::remember('admin_contacts_list', 30, function () {
            // Optional: Filter out career requests from general messages
            return Contact::whereNotIn('purpose', ['job_seeker', 'hiring'])->latest()->paginate(10);
        });
        
        return view('admin.contacts', compact('contacts'));
    }

    public function careerRequests()
    {
        // OLD: Fetching contacts.
        // $careerRequests = Cache::remember('admin_career_requests_all', 30, function () {
        //     return Contact::whereIn('purpose', ['job_seeker', 'hiring'])->latest()->get();
        // });
        // $jobSeekers = $careerRequests->where('purpose', 'job_seeker');
        // $employers = $careerRequests->where('purpose', 'hiring');

        // NEW: Fetching real JobApplications from the portal
        // Get all Job Applications with User data
        $applications = JobApplication::with('user')->latest()->get();
        
        // Get all Employers (Users with role 'employer')
        // We might want to list them even if they haven't done anything yet
        $employers = \App\Models\User::where('role', 'employer')->latest()->get();

        return view('admin.career_requests', compact('applications', 'employers'));
    }

    public function adminUpdateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,is_read,interview,shortlisted,rejected',
        ]);

        $application->update(['status' => $request->status]);

        Cache::forget('admin_unread_job_apps');
        Cache::forget('admin_dashboard_stats');

        return redirect()->back()->with('success', 'Application status updated successfully by Admin.');
    }

    public function adminDownloadCv(JobApplication $application)
    {
        if (!Storage::disk('public')->exists($application->cv_path)) {
           return redirect()->back()->with('error', 'CV file not found.');
        }
        return response()->download(Storage::disk('public')->path($application->cv_path));
    }

    public function businessInquiries()
    {
        $inquiries = BusinessInquiry::with('user')->latest()->get();
        return view('admin.business_inquiries', compact('inquiries'));
    }

    public function adminUpdateBusinessStatus(Request $request, BusinessInquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,connected',
        ]);

        $inquiry->update(['status' => $request->status]);

        Cache::forget('admin_unread_business');
        Cache::forget('admin_dashboard_stats');

        return redirect()->back()->with('success', 'Business inquiry status updated.');
    }

    public function freelanceInquiries()
    {
        $inquiries = FreelanceInquiry::with('user')->latest()->get();
        return view('admin.freelance_inquiries', compact('inquiries'));
    }

    public function adminUpdateFreelanceStatus(Request $request, FreelanceInquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,completed,rejected',
            'estimated_completion_date' => 'nullable|date',
            'admin_notes' => 'nullable|string',
        ]);

        $inquiry->update([
            'status' => $request->status,
            'estimated_completion_date' => $request->estimated_completion_date,
            'admin_notes' => $request->admin_notes,
        ]);

        Cache::forget('admin_unread_freelance');
        Cache::forget('admin_dashboard_stats');

        return redirect()->back()->with('success', 'Freelance project updated details saved.');
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:job_seeker,employer,business_partner,freelance_client',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        Cache::forget('admin_dashboard_stats');
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function chats()
    {
        // Get users who have messages, ordered by most recent message
        $users = User::whereHas('chatMessages')
            ->withCount(['chatMessages as unread_count' => function($query) {
                $query->where('is_from_admin', false)->where('is_read', false);
            }])
            ->latest()
            ->paginate(15);
            
        return view('admin.chats', compact('users'));
    }

    public function userChat(User $user)
    {
        $messages = $user->chatMessages()->orderBy('created_at', 'asc')->get();
        
        // Mark user messages as read
        $user->chatMessages()->where('is_from_admin', false)->update(['is_read' => true]);
        
        Cache::forget('admin_dashboard_stats');
        Cache::forget('admin_unread_chat');
        
        return view('admin.user_chat', compact('user', 'messages'));
    }

    public function adminSendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user->chatMessages()->create([
            'message' => $request->message,
            'is_from_admin' => true,
        ]);

        Cache::forget('admin_dashboard_stats');

        return back();
    }

    public function feedbacks()
    {
        $feedbacks = Feedback::latest()->paginate(20);
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function adminUpdateFeedbackStatus(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,hidden',
        ]);

        $feedback->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Feedback status updated.');
    }

    public function deleteFeedback(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback deleted.');
    }

    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }

        Cache::forget('admin_dashboard_stats');
        
        return redirect()->back()->with('success', 'Global settings updated.');
    }

    public function callbacks()
    {
        // Cache callbacks list for 30s
        $callbacks = Cache::remember('admin_callbacks_list', 30, function () {
            return Callback::latest()->paginate(10);
        });
        
        return view('admin.callbacks', compact('callbacks'));
    }

    public function projects()
    {
        // Cache projects list for 60s
        $projects = Cache::remember('admin_projects_list', 60, function () {
            return Project::latest()->paginate(10);
        });

        return view('admin.projects', compact('projects'));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|string',
        ]);

        Project::create($request->all());

        return redirect()->back()->with('success', 'Project added successfully!');
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|string',
        ]);

        $project->update($request->all());

        return redirect()->back()->with('success', 'Project updated successfully!');
    }


    public function deleteProject(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully!');
    }

    public function markContactAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        
        // Clear caches so the UI updates instantly
        Cache::forget('admin_unread_contacts');
        Cache::forget('admin_unread_career');
        Cache::forget('admin_contacts_list');
        Cache::forget('admin_career_requests_all');
        Cache::forget('admin_recent_contacts');
        Cache::forget('admin_dashboard_stats');
        
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function markCallbackAsRead(Callback $callback)
    {
        $callback->update(['is_read' => true]);
        
        // Clear caches so the UI updates instantly
        Cache::forget('admin_unread_callbacks');
        Cache::forget('admin_callbacks_list');
        Cache::forget('admin_recent_callbacks');
        Cache::forget('admin_dashboard_stats');
        
        return redirect()->back()->with('success', 'Callback marked as read.');
    }
}


