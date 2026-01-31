<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contact;
use App\Models\Callback;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PortfolioController extends Controller
{
    public function index() {
        $projects = Project::all();
        
        return view('portfolio.index', compact('projects'));
    }

    public function sendMessage(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'purpose' => 'required|string',
            'message' => 'required|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:3072', // Max 3MB
        ]);

        $purposeLabels = [
            'general' => 'General Inquiry',
            'freelancing' => 'Freelancing Project',
            'business' => 'Business Growth Discussion',
            'technology' => 'Technology Consultation',
            'job_seeker' => 'Career: Need Job (Job Seeker)',
            'hiring' => 'Career: Hiring (Employer)'
        ];

        // If purpose is NOT in the list, keep the raw value (for job_seeker/hiring it will now be mapped correctly or kept raw if I use raw values in DB)
        // Actually, let's just stick to raw values in DB for consistency if I want to filter, OR save the label.
        // My AdminController filters by 'job_seeker' and 'hiring' raw values.
        // But here I am overwriting $purpose with the Label.
        // Wait! In AdminController I am filtering by `where('purpose', 'job_seeker')`. 
        // If I save "Career: Need Job..." to DB, that filter will BREAK.
        // I should SAVE the RAW 'job_seeker' code in DB, but use the label for Email.
        
        $rawPurpose = $request->purpose;
        $readablePurpose = $purposeLabels[$rawPurpose] ?? $rawPurpose;

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        // --- Account Creation Logic ---
        if (in_array($rawPurpose, ['job_seeker', 'hiring'])) {
            $user = User::where('email', $request->email)->first();
            $role = ($rawPurpose === 'job_seeker') ? 'job_seeker' : 'employer';

            if (!$user) {
                $generatedPassword = Str::password(10);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($generatedPassword),
                    'role' => $role
                ]);

                // Send Credentials to User
                $loginUrl = route('portal.login');
                $userMailMessage = "Hi {$request->name},\n\nAn account has been created for you on Mukesh's Job Portal.\n\nLogin here: {$loginUrl}\nEmail: {$request->email}\nPassword: {$generatedPassword}\n\nKeep these credentials safe!";
                
                Mail::raw($userMailMessage, function ($mail) use ($user) {
                    $mail->to($user->email)->subject("Your Job Portal Credentials");
                });
            }

            // Create Job Application record for job seekers
            if ($role === 'job_seeker' && $cvPath) {
                JobApplication::updateOrCreate(
                    ['user_id' => $user->id],
                    ['cv_path' => $cvPath, 'status' => 'pending']
                );
            }
        }

        // Save to Database (Contact Record for Admin View)
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'purpose' => $rawPurpose,
            'message' => $request->message,
            'cv_path' => $cvPath,
        ]);

        // Send email to Admin
        Mail::raw("Purpose: {$readablePurpose}\n\n{$request->message}", function ($mail) use ($request, $readablePurpose, $cvPath) {
            $mail->to('mukeshrk2003@gmail.com')
                 ->replyTo($request->email, $request->name)
                 ->subject("Portfolio Contact: {$readablePurpose}");
            
            if ($cvPath) {
                $mail->attach(storage_path('app/public/' . $cvPath));
            }
        });

        return back()->with('success', 'Message sent successfully!');
    }

    public function requestCallback(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'purpose' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $purposeLabels = [
            'general' => 'General Inquiry',
            'freelancing' => 'Freelancing Project',
            'business' => 'Business Growth Discussion',
            'technology' => 'Technology Consultation',
        ];

        $purpose = $purposeLabels[$request->purpose] ?? $request->purpose;

        // Save to Database
        Callback::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'purpose' => $purpose,
            'message' => $request->message,
        ]);

        // Send email
        $body = "Purpose: {$purpose}\nName: {$request->name}\nPhone: {$request->phone}\nEmail: {$request->email}\nMessage: {$request->message}";

        Mail::raw($body, function ($mail) use ($request, $purpose) {
            $mail->to('mukeshrk2003@gmail.com')
                 ->replyTo($request->email, $request->name)
                 ->subject("Callback Request: {$purpose}");
        });


        return back()->with('success', 'Callback request sent successfully!');
    }
}
