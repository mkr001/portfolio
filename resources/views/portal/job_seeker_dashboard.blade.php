@extends('portal.layout')

@section('title', 'Dashboard')

@section('content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Hello, {{ $user->name }}</h1>
            <p style="color: var(--text-muted);">Welcome to your career dashboard.</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.875rem; color: var(--text-muted);">Current Role</div>
            <div class="badge badge-viewed">Job Seeker</div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Application Status Card -->
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
            <h3>Application Status</h3>
            @if($application)
                <div style="margin: 1.5rem 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                        <span style="color: var(--text-muted);">Current Status</span>
                        <span class="badge badge-{{ $application->status }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                        <span style="color: var(--text-muted);">Target Role</span>
                        <span style="font-weight: 500;">{{ $application->job_title }}</span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="color: var(--text-muted);">Submission Date</span>
                        <span>{{ $application->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @else
                <p style="color: var(--text-muted); margin: 1.5rem 0;">You haven't submitted your CV yet.</p>
            @endif
        </div>

        <!-- Views Card -->
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
            <h3>Profile Visibility</h3>
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 150px;">
                <div style="font-size: 4rem; font-weight: 700; background: linear-gradient(to right, #34d399, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    {{ $application ? $application->views : 0 }}
                </div>
                <div style="color: var(--text-muted);">HR Views</div>
            </div>
        </div>
    </div>

    <!-- Upload Section -->
    <div class="glass-card" style="margin-top: 2rem; background: rgba(255, 255, 255, 0.03);">
        <h3>{{ $application ? 'Update Your CV' : 'Submit Your Application' }}</h3>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
            Upload your latest CV/Resume to be visible to our hiring team.
        </p>

        <form action="{{ route('portal.upload_cv') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="job_title">Target Job Title</label>
                    <input type="text" id="job_title" name="job_title" placeholder="e.g. Software Engineer" value="{{ $application ? $application->job_title : '' }}" required>
                </div>
                
                <div class="form-group">
                    <label for="cv">CV Document (PDF, DOCX)</label>
                    <input type="file" id="cv" name="cv" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $application ? 'Update Application' : 'Submit Application' }}
            </button>
        </form>
    </div>
</div>
@endsection
