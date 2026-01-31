@extends('portal.layout')

@section('title', 'Employer Dashboard')

@section('content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Employer Dashboard</h1>
            <p style="color: var(--text-muted);">Manage recruitment and view applicants.</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.875rem; color: var(--text-muted);">Current Role</div>
            <div class="badge badge-shortlisted">Hiring Team</div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Total Applicants -->
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
            <h3>Total Applicants</h3>
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 150px;">
                <div style="font-size: 4rem; font-weight: 700; background: linear-gradient(to right, #60a5fa, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    {{ $applicantCount }}
                </div>
                <div style="color: var(--text-muted);">Candidates</div>
            </div>
            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('portal.applicants') }}" class="btn btn-primary" style="width: 100%;">View All Applicants</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
            <h3>Quick Actions</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('portal.applicants') }}" class="btn btn-secondary" style="text-align: left; display: flex; justify-content: space-between; align-items: center;">
                    <span>Review Pending CVs</span>
                    <span>&rarr;</span>
                </a>
                <!-- Future actions can go here -->
            </div>
        </div>
    </div>
</div>
@endsection
