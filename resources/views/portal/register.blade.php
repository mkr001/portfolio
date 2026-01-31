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
                <label for="age">Age</label>
                <input type="number" id="age" name="age" value="{{ old('age') }}" min="1" max="120" required placeholder="How old are you?">
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="{{ old('dob') }}" required>
            </div>

            <div class="form-group">
                <label for="role">I am a...</label>
                <select name="role" id="role" required onchange="toggleCustomRole(this.value)">
                    <option value="job_seeker" {{ (request('role') == 'job_seeker' || old('role') == 'job_seeker') ? 'selected' : '' }}>Job Seeker</option>
                    <option value="employer" {{ (request('role') == 'employer' || old('role') == 'employer') ? 'selected' : '' }}>Employer / Hiring Manager</option>
                    <option value="business_partner" {{ (request('role') == 'business_partner' || old('role') == 'business_partner') ? 'selected' : '' }}>Business Partner / Growth</option>
                    <option value="freelance_client" {{ (request('role') == 'freelance_client' || old('role') == 'freelance_client') ? 'selected' : '' }}>Freelance Client (Hire Me)</option>
                    <option value="other" {{ old('role') == 'other' ? 'selected' : '' }}>Other (Custom Type)</option>
                </select>
            </div>

            <div class="form-group" id="custom-role-group" style="display: {{ old('role') == 'other' ? 'block' : 'none' }};">
                <label for="custom_role">Please specify (Student, Parent, etc.)</label>
                <input type="text" id="custom_role" name="custom_role" value="{{ old('custom_role') }}" placeholder="Enter your role...">
            </div>

            <script>
                function toggleCustomRole(value) {
                    const group = document.getElementById('custom-role-group');
                    const input = document.getElementById('custom_role');
                    if (value === 'other') {
                        group.style.display = 'block';
                        input.setAttribute('required', 'required');
                    } else {
                        group.style.display = 'none';
                        input.removeAttribute('required');
                    }
                }
            </script>

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
