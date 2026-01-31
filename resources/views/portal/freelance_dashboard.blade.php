@extends('portal.layout')

@section('title', 'Freelance Dashboard')

@section('content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Hello, {{ $user->name }}</h1>
            <p style="color: var(--text-muted);">Let's build something amazing together.</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.875rem; color: var(--text-muted);">Current Role</div>
            <div class="badge badge-interview">Freelance Client</div>
        </div>
    </div>

    <!-- Inquiry Status -->
    @if($inquiry)
        <div class="glass-card" style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); margin-bottom: 2rem;">
            <div style="display:flex; justify-content:space-between; align-items: flex-start;">
                <div>
                    <h3 style="color: #60a5fa;">Project Status: {{ ucfirst($inquiry->status) }}</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">
                        <strong>Project:</strong> {{ $inquiry->project_title }}
                    </p>
                </div>
                @if($inquiry->status == 'accepted')
                     <div style="text-align: right;">
                        <span style="font-size: 0.8rem; color: #94a3b8;">Estimated Completion</span>
                        <div style="font-size: 1.2rem; font-weight: bold; color: #4ade80;">
                            {{ $inquiry->estimated_completion_date ? $inquiry->estimated_completion_date->format('M d, Y') : 'TBD' }}
                        </div>
                     </div>
                @endif
            </div>

            @if($inquiry->admin_notes)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                    <p style="font-size: 0.9rem; color: #cbd5e1;">
                        <strong style="color: #94a3b8;">Admin Notes:</strong><br>
                        {{ $inquiry->admin_notes }}
                    </p>
                </div>
            @endif
        </div>
    @endif

    <!-- Project Form -->
    <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
        <h3>{{ $inquiry ? 'Update Project Details' : 'Start a New Project' }}</h3>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
            Tell me about what you need built.
        </p>

        <form action="{{ route('portal.freelance.submit') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="project_title">Project Title</label>
                <input type="text" id="project_title" name="project_title" value="{{ $inquiry ? $inquiry->project_title : old('project_title') }}" required placeholder="e.g. E-commerce Website">
            </div>

            <div class="form-group">
                <label for="project_description">Project Details</label>
                <textarea name="project_description" id="project_description" rows="5" style="width: 100%; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--border-color); border-radius: 8px; color: white;" required placeholder="Describe requirements, tech stack preference, etc...">{{ $inquiry ? $inquiry->project_description : old('project_description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="budget_range">Budget Range (Optional)</label>
                <input type="text" id="budget_range" name="budget_range" value="{{ $inquiry ? $inquiry->budget_range : old('budget_range') }}" placeholder="e.g. $500 - $1000">
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $inquiry ? 'Update Project' : 'Submit Request' }}
            </button>
        </form>
    </div>
</div>
@endsection
