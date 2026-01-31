<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\BusinessInquiry;
use App\Models\FreelanceInquiry;
use App\Models\ChatMessage;
use App\Models\Feedback;
use App\Models\Donation;

class JobPortalController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:job_seeker,employer,business_partner,freelance_client'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route('portal.dashboard');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('portal.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->role === 'job_seeker') {
            $application = $user->jobApplication;
            return view('portal.job_seeker_dashboard', compact('user', 'application'));
        } elseif ($user->role === 'employer') {
            $applicantCount = JobApplication::count();
            return view('portal.employer_dashboard', compact('user', 'applicantCount'));
        } elseif ($user->role === 'business_partner') {
            $inquiry = $user->businessInquiry;
            return view('portal.business_dashboard', compact('user', 'inquiry'));
        } elseif ($user->role === 'freelance_client') {
            $inquiry = $user->freelanceInquiry;
            return view('portal.freelance_dashboard', compact('user', 'inquiry'));
        }

        return redirect()->route('home');
    }

    public function submitFreelanceInquiry(Request $request) {
        $request->validate([
           'project_title' => 'required|string|max:255',
           'project_description' => 'required|string',
           'budget_range' => 'nullable|string',
       ]);

       $user = Auth::user();

       FreelanceInquiry::updateOrCreate(
           ['user_id' => $user->id],
           [
               'project_title' => $request->project_title,
               'project_description' => $request->project_description,
               'budget_range' => $request->budget_range,
               'status' => 'pending'
           ]
       );

       return back()->with('success', 'Project request submitted! Waiting for Admin review.');
   }


    public function submitBusinessInquiry(Request $request) {
         $request->validate([
            'business_name' => 'required|string|max:255',
            'current_challenges' => 'required|string',
            'goals' => 'required|string',
        ]);

        $user = Auth::user();

        BusinessInquiry::updateOrCreate(
            ['user_id' => $user->id],
            [
                'business_name' => $request->business_name,
                'current_challenges' => $request->current_challenges,
                'goals' => $request->goals,
                'status' => 'pending'
            ]
        );

        return back()->with('success', 'Business inquiry submitted successfully! We will connect soon.');
    }

    public function chat()
    {
        $user = Auth::user();
        $messages = $user->chatMessages()->orderBy('created_at', 'asc')->get();
        
        // Mark all admin messages as read when user opens chat
        $user->chatMessages()->where('is_from_admin', true)->update(['is_read' => true]);
        
        return view('portal.chat', compact('user', 'messages'));
    }

    public function sendChatMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Auth::user()->chatMessages()->create([
            'message' => $request->message,
            'is_from_admin' => false,
        ]);

        \Illuminate\Support\Facades\Cache::forget('admin_dashboard_stats');
        \Illuminate\Support\Facades\Cache::forget('admin_unread_chat');

        return back();
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        Feedback::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Thank you for your feedback! It has been submitted for review.');
    }

    public function reportDonation(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'transaction_id' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        Donation::create([
            'user_id' => Auth::id(),
            'donor_name' => $request->donor_name,
            'amount' => $request->amount,
            'transaction_id' => $request->transaction_id,
            'message' => $request->message,
            'is_published' => false,
        ]);

        return back()->with('success', 'Thank you for your donation report! Mukesh will review it and add you to the Wall of Fame.');
    }



    public function applicants()
    {
        if (Auth::user()->role !== 'employer') {
            return redirect()->route('portal.dashboard');
        }

        $applicants = JobApplication::with('user')->latest()->paginate(10);
        return view('portal.applicants', compact('applicants'));
    }

    public function viewCv(JobApplication $application)
    {
        if (Auth::user()->role !== 'employer') {
            return redirect()->route('portal.dashboard');
        }

        // Increment views count whenever an employer views the CV
        $application->increment('views');

        return response()->file(Storage::disk('public')->path($application->cv_path));
    }

    public function uploadCv(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        if ($user->jobApplication) {
            Storage::delete($user->jobApplication->cv_path);
            $user->jobApplication->delete();
        }

        $path = $request->file('cv')->store('cvs', 'public');

        JobApplication::create([
            'user_id' => $user->id,
            'job_title' => $request->job_title,
            'cv_path' => $path,
            'status' => 'pending',
        ]);

        return back()->with('success', 'CV uploaded successfully!');
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        if (Auth::user()->role !== 'employer') {
            abort(403); 
        }

        $request->validate([
            'status' => 'required|in:pending,shortlisted,rejected,interview',
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('portal.login');
    }
}
