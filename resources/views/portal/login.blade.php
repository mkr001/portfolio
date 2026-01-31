@extends('portal.layout')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="glass-card auth-card">
        <h2 style="text-align: center; margin-bottom: 2rem;">Welcome Back</h2>
        
        <form action="{{ route('portal.login.post') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="color: var(--text-muted); font-size: 0.875rem;">
                Don't have an account? <a href="{{ route('portal.register') }}">Register here</a>
            </p>
        </div>
    </div>
</div>
@endsection
