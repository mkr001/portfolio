@extends('portal.layout')

@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="glass-card auth-card">
        <h2 style="text-align: center; margin-bottom: 2rem;">Create Account</h2>
        
        <form action="{{ route('portal.register.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="role">I am a...</label>
                <select name="role" id="role" required>
                    <option value="job_seeker" {{ (request('role') == 'job_seeker' || old('role') == 'job_seeker') ? 'selected' : '' }}>Job Seeker</option>
                    <option value="employer" {{ (request('role') == 'employer' || old('role') == 'employer') ? 'selected' : '' }}>Employer / Hiring Manager</option>
                    <option value="business_partner" {{ (request('role') == 'business_partner' || old('role') == 'business_partner') ? 'selected' : '' }}>Business Partner / Growth</option>
                    <option value="freelance_client" {{ (request('role') == 'freelance_client' || old('role') == 'freelance_client') ? 'selected' : '' }}>Freelance Client (Hire Me)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: var(--text-muted); font-size: 0.875rem;">
                Already have an account? <a href="{{ route('portal.login') }}">Login here</a>
            </p>
        </div>
    </div>
</div>
@endsection
