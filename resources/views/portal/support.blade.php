@extends('portal.layout')

@section('title', 'Support Mukesh')

@section('content')
<div class="glass-card text-center" style="max-w: 600px; margin: 2rem auto; text-align: center; padding: 3rem;">
    <div style="font-size: 4rem; margin-bottom: 1rem;">☕</div>
    <h1 style="margin-bottom: 1rem; color: #fff;">Support the Platform</h1>
    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 2rem;">
        Everything on this platform—from job connections to business consulting—is provided completely <strong>free of charge</strong>. 
        Your support helps keep the servers running and allows me to dedicate more time to helping others grow their careers and businesses.
    </p>

    <!-- Donation Options -->
    <div style="background: rgba(255, 255, 255, 0.03); border-radius: 20px; padding: 2rem; border: 1px solid rgba(255,255,255,0.05);">
        <h3 style="margin-bottom: 1.5rem;">Choose how to support</h3>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @php
                $donationLink = \App\Models\Setting::get('donation_link', 'https://buymeacoffee.com/mukesh');
                $upiId = \App\Models\Setting::get('upi_id', 'mukesh@upi');
            @endphp
            <a href="{{ $donationLink }}" target="_blank" class="btn btn-primary" style="background: #FFDD00; color: #000; border: none; font-weight: bold;">
                Buy Me a Coffee
            </a>
            <p style="font-size: 0.8rem; color: var(--text-muted);">Secure payment via Stripe/PayPal</p>
            
            <div style="margin: 1.5rem 0; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
                <p style="margin-bottom: 0.5rem; color: #fff; font-weight: bold;">Scan to donate via UPI</p>
                <!-- Dynamic QR Code based on Setting -->
                <div style="width: 150px; height: 150px; background: #fff; margin: 0 auto; border-radius: 10px; display: flex; items-center; justify-content: center; color: #000; font-weight: bold; overflow: hidden;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa={{ $upiId }}" alt="UPI QR Code">
                </div>
                <p style="font-size: 0.8rem; color: var(--text-muted); mt-2;">{{ $upiId }}</p>
            </div>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('portal.dashboard') }}" style="color: var(--text-muted); font-size: 0.9rem; text-decoration: none;">
            ← Back to Dashboard
        </a>
    </div>
</div>
@endsection
