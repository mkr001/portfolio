@extends('portal.layout')

@section('title', 'Applicants')

@section('content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Applicants</h1>
            <p style="color: var(--text-muted);">Review and manage candidate applications.</p>
        </div>
        <a href="{{ route('portal.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="table-container glass-card" style="background: rgba(255, 255, 255, 0.03); padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Job Title</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                    <th>Views</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applicants as $app)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: white;">{{ $app->user->name }}</div>
                        <div style="font-size: 0.875rem; color: var(--text-muted);">{{ $app->user->email }}</div>
                    </td>
                    <td>{{ $app->job_title }}</td>
                    <td>
                        <span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span>
                    </td>
                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                    <td>{{ $app->views }}</td>
                    <td>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <a href="{{ route('portal.view_cv', $app->id) }}" target="_blank" class="btn btn-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">View CV</a>
                            
                            <form action="{{ route('portal.update_status', $app->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <select name="status" onchange="this.form.submit()" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; width: auto; background: rgba(0,0,0,0.3);">
                                    <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="shortlisted" {{ $app->status == 'shortlisted' ? 'selected' : '' }}>Shortlist</option>
                                    <option value="interview" {{ $app->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                    <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                </select>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem;">
                        <p style="color: var(--text-muted);">No applications found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        {{ $applicants->links() }}
    </div>
</div>
@endsection
