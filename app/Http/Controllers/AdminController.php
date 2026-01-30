<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Callback;
use App\Models\Project;

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
        $stats = [
            'contacts' => Contact::count(),
            'callbacks' => Callback::count(),
            'projects' => Project::count(),
        ];
        
        $recentContacts = Contact::latest()->take(5)->get();
        $recentCallbacks = Callback::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentCallbacks'));
    }


    public function contacts()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }

    public function callbacks()
    {
        $callbacks = Callback::latest()->paginate(10);
        return view('admin.callbacks', compact('callbacks'));
    }

    public function projects()
    {
        $projects = Project::latest()->paginate(10);
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
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    public function markCallbackAsRead(Callback $callback)
    {
        $callback->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Callback marked as read.');
    }
}


