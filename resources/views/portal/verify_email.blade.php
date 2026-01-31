@extends('portal.layout')

@section('title', 'Verify Email')

@section('content')
<div class="glass-card" style="max-width: 500px; margin: 3rem auto; padding: 3rem;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">📧</div>
        <h1 style="margin-bottom: 0.5rem;">Verify Your Email</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            We've sent a 6-digit code to <strong>{{ session('registration_data')['email'] ?? 'your email' }}</strong>
        </p>
    </div>

    @if(session('success'))
        <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('portal.verify_email.post') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="otp" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Enter 6-Digit Code</label>
            <input 
                type="text" 
                id="otp" 
                name="otp" 
                maxlength="6" 
                pattern="[0-9]{6}"
                placeholder="000000"
                required
                autofocus
                style="width: 100%; padding: 1rem; font-size: 1.5rem; text-align: center; letter-spacing: 0.5rem; font-weight: bold; background: rgba(255, 255, 255, 0.05); border: 2px solid rgba(255, 255, 255, 0.1); border-radius: 12px; color: #fff; outline: none; transition: all 0.3s;"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            >
            @error('otp')
                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; font-weight: bold;">
            Verify & Create Account
        </button>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        <p style="color: var(--text-muted); font-size: 0.875rem;">
            Didn't receive the code? 
            <a href="{{ route('portal.register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                Register again
            </a>
        </p>
    </div>

    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.1); text-align: center;">
        <p style="color: var(--text-muted); font-size: 0.8rem;">
            ⏱️ Code expires in 10 minutes
        </p>
    </div>
</div>

<style>
    input#otp:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>
@endsection
