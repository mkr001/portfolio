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
use App\Models\Friendship;

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
            'role' => ['required', 'in:job_seeker,employer,business_partner,freelance_client,other'],
            'custom_role' => ['required_if:role,other', 'nullable', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'in:male,female,other'],
            'dob' => ['required', 'date'],
        ]);

        // Store registration data in session
        session([
            'registration_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
                'custom_role' => $request->role === 'other' ? $request->custom_role : null,
                'age' => $request->age,
                'gender' => $request->gender,
                'dob' => $request->dob,
            ]
        ]);

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        session([
            'registration_otp' => $otp,
            'registration_otp_expires_at' => now()->addMinutes(10)->timestamp
        ]);

        return redirect()->route('portal.verify_email')->with('success', 'Please check your email for the verification code. (For testing: ' . $otp . ')');
    }

    public function verifyEmail()
    {
        if (!session('registration_data')) {
            return redirect()->route('portal.register')->with('error', 'Please register first.');
        }
        return view('portal.verify_email');
    }

    public function doVerifyEmail(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $registrationData = session('registration_data');
        $sessionOtp = session('registration_otp');
        $otpExpiresAt = session('registration_otp_expires_at');

        if (!$registrationData || !$sessionOtp) {
            return back()->with('error', 'Session expired. Please register again.');
        }

        // Check if OTP has expired
        if ($otpExpiresAt && now()->timestamp > $otpExpiresAt) {
            session()->forget(['registration_data', 'registration_otp', 'registration_otp_expires_at']);
            return redirect()->route('portal.register')->with('error', 'OTP has expired. Please register again.');
        }

        if ($request->otp !== $sessionOtp) {
            return back()->with('error', 'Invalid OTP. Please try again.');
        }

        // Create the user account
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($registrationData['password']),
            'role' => $registrationData['role'],
            'custom_role' => $registrationData['custom_role'] ?? null,
            'age' => $registrationData['age'],
            'gender' => $registrationData['gender'],
            'dob' => $registrationData['dob'],
            'email_verified_at' => now(),
        ]);

        // Clear session data
        session()->forget(['registration_data', 'registration_otp', 'registration_otp_expires_at']);

        // Log the user in
        Auth::login($user);

        return redirect()->route('portal.dashboard')->with('success', 'Email verified successfully! Welcome to your dashboard.');
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
        } elseif ($user->role === 'other') {
            return view('portal.custom_dashboard', compact('user'));
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
        $messages = $user->chatMessages()->whereNull('friendship_id')->orderBy('created_at', 'asc')->get();
        
        // Mark all admin messages as read when user opens chat
        $user->chatMessages()->whereNull('friendship_id')->where('is_from_admin', true)->where('is_read', false)->update(['is_read' => true]);
        \Illuminate\Support\Facades\Cache::forget("user_{$user->id}_admin_chat_unread");
        
        return view('portal.chat', compact('user', 'messages'));
    }

    public function sendChatMessage(Request $request)
    {
        $request->validate([
            'message' => 'nullable|required_without:image|string',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        Auth::user()->chatMessages()->create([
            'message' => $request->message,
            'image_path' => $imagePath,
            'is_from_admin' => false,
        ]);

        \Illuminate\Support\Facades\Cache::forget("user_" . Auth::id() . "_admin_chat_unread");
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

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = [];
        if ($query) {
            $users = User::where('name', 'LIKE', "%{$query}%")
                ->where('id', '!=', Auth::id())
                ->where('role', '!=', 'admin')
                ->whereDoesntHave('sentFriendRequests', function($q) {
                    $q->where('receiver_id', Auth::id())->where('status', 'blocked');
                })
                ->whereDoesntHave('receivedFriendRequests', function($q) {
                    $q->where('sender_id', Auth::id())->where('status', 'blocked');
                })
                ->get();
        }
        return view('portal.users_search', compact('users', 'query'));
    }

    public function sendFriendRequest(User $user)
    {
        if (Auth::user()->isFriendsWith($user->id) || Auth::user()->hasSentRequestTo($user->id)) {
            return back()->with('error', 'Friend request already sent or you are already friends.');
        }

        Friendship::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    public function friendRequests()
    {
        $requests = Auth::user()->receivedFriendRequests()->where('status', 'pending')->with('sender')->get();
        return view('portal.friend_requests', compact('requests'));
    }

    public function acceptFriendRequest(Friendship $friendship)
    {
        if ($friendship->receiver_id !== Auth::id()) {
            abort(403);
        }

        $friendship->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted!');
    }

    public function rejectFriendRequest(Friendship $friendship)
    {
        if ($friendship->receiver_id !== Auth::id()) {
            abort(403);
        }

        $friendship->update(['status' => 'rejected']);

        return back()->with('success', 'Friend request rejected.');
    }

    public function friendsList()
    {
        $friends = Auth::user()->friends();
        // We also need the friendships to get the chat links
        $friendships = Friendship::where('status', 'accepted')
            ->where(function($q) {
                $q->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })->with(['sender', 'receiver'])->get();

        return view('portal.friends_list', compact('friendships'));
    }

    public function friendChat(Friendship $friendship)
    {
        if (!in_array(Auth::id(), [$friendship->sender_id, $friendship->receiver_id]) || $friendship->status !== 'accepted') {
            abort(403);
        }

        $otherUser = $friendship->getOtherUser(Auth::id());
        $messages = ChatMessage::where('friendship_id', $friendship->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $userId = Auth::id();
        ChatMessage::where('friendship_id', $friendship->id)
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        \Illuminate\Support\Facades\Cache::forget("user_{$userId}_friend_chat_unread");

        return view('portal.friend_chat', compact('friendship', 'otherUser', 'messages'));
    }

    public function sendFriendMessage(Request $request, Friendship $friendship)
    {
        if (!in_array(Auth::id(), [$friendship->sender_id, $friendship->receiver_id]) || $friendship->status !== 'accepted') {
            abort(403);
        }

        $request->validate([
            'message' => 'nullable|required_without:image|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        ChatMessage::create([
            'user_id' => Auth::id(),
            'friendship_id' => $friendship->id,
            'message' => $request->message,
            'image_path' => $imagePath,
            'is_from_admin' => false,
            'is_read' => false,
        ]);

        $otherUserId = $friendship->getOtherUser(Auth::id())->id;
        \Illuminate\Support\Facades\Cache::forget("user_{$otherUserId}_friend_chat_unread");

        return back();
    }

    public function blockFriend(Friendship $friendship)
    {
        if (!in_array(Auth::id(), [$friendship->sender_id, $friendship->receiver_id])) {
            abort(403);
        }

        $friendship->update(['status' => 'blocked']);

        return redirect()->route('portal.friends.list')->with('success', 'User blocked successfully.');
    }
}
