<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Contact;
use App\Models\Callback;
use Illuminate\Support\Facades\Mail;


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
        ]);

        $purposeLabels = [
            'general' => 'General Inquiry',
            'freelancing' => 'Freelancing Project',
            'business' => 'Business Growth Discussion',
            'technology' => 'Technology Consultation',
        ];

        $purpose = $purposeLabels[$request->purpose] ?? $request->purpose;

        // Save to Database
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'purpose' => $purpose,
            'message' => $request->message,
        ]);

        // Send email

        Mail::raw("Purpose: {$purpose}\n\n{$request->message}", function ($mail) use ($request, $purpose) {
            $mail->to('mukeshrk2003@gmail.com')
                 ->replyTo($request->email, $request->name)
                 ->subject("Portfolio Contact: {$purpose}");
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
