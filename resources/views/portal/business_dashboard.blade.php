@extends('portal.layout')

@section('title', 'Business Dashboard')

@section('content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1>Hello, {{ $user->name }}</h1>
            <p style="color: var(--text-muted);">Let's grow your business together.</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.875rem; color: var(--text-muted);">Current Role</div>
            <div class="badge badge-shortlisted">Business Partner</div>
        </div>
    </div>

    <!-- Inquiry Status -->
    @if($inquiry)
        <div class="glass-card" style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.2); margin-bottom: 2rem;">
            <h3 style="color: #4ade80;">Inquiry Submitted</h3>
            <p style="color: var(--text-muted);">
                We have received your business details. Status: 
                <span class="badge badge-{{ $inquiry->status }}" style="margin-left: 0.5rem;">{{ ucfirst($inquiry->status) }}</span>
            </p>
            <p style="margin-top: 1rem; font-size: 0.9rem;">
                <strong>Business Name:</strong> {{ $inquiry->business_name }}
            </p>
        </div>
    @endif

    <!-- Business Form -->
    <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
        <h3>{{ $inquiry ? 'Update Business Details' : 'Tell Us About Your Business' }}</h3>
        <p style="color: var(--text-muted); margin-bottom: 1.5rem;">
            Fill in the details below so we can understand your needs and help you improve.
        </p>

        <form action="{{ route('portal.business.submit') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="business_name">Business Name</label>
                <input type="text" id="business_name" name="business_name" value="{{ $inquiry ? $inquiry->business_name : old('business_name') }}" required placeholder="e.g. Acme Corp">
            </div>

            <div class="form-group">
                <label for="current_challenges">Current Challenges (What things to improve?)</label>
                <textarea name="current_challenges" id="current_challenges" rows="4" style="width: 100%; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--border-color); border-radius: 8px; color: white;" required placeholder="Describe what's not working well...">{{ $inquiry ? $inquiry->current_challenges : old('current_challenges') }}</textarea>
            </div>

            <div class="form-group">
                <label for="goals">Business Goals (Where do you want to be?)</label>
                <textarea name="goals" id="goals" rows="4" style="width: 100%; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.5); border: 1px solid var(--border-color); border-radius: 8px; color: white;" required placeholder="Describe your targets...">{{ $inquiry ? $inquiry->goals : old('goals') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $inquiry ? 'Update Details' : 'Submit Inquiry' }}
            </button>
        </form>
    </div>
    @include('portal.partials.wall_of_fame')
</div>
@endsection
