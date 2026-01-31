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
                <div style="width: 150px; height: 150px; background: #fff; margin: 0 auto; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa={{ $upiId }}" alt="UPI QR Code">
                </div>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">{{ $upiId }}</p>
            </div>
        </div>
    </div>

    <!-- Report Donation Form -->
    <div style="background: rgba(255, 255, 255, 0.03); border-radius: 20px; padding: 2rem; border: 1px solid rgba(255,255,255,0.05); margin-top: 2rem;">
        <h3 style="margin-bottom: 1.5rem;">Done donating? Let me know!</h3>
        <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.5rem;">Submit this form so I can personally thank you on our wall of fame.</p>
        
        <form action="{{ route('portal.donation.report') }}" method="POST" style="text-align: left; display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 0.5rem;">Your Name / Public Name</label>
                <input type="text" name="donor_name" value="{{ auth()->user()->name }}" required 
                       style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0.75rem; color: #fff;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.8rem; margin-bottom: 0.5rem;">Amount (₹)</label>
                    <input type="number" name="amount" placeholder="Optional"
                           style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0.75rem; color: #fff;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; margin-bottom: 0.5rem;">Trans. ID (Internal)</label>
                    <input type="text" name="transaction_id" placeholder="Optional"
                           style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0.75rem; color: #fff;">
                </div>
            </div>
            <div>
                <label style="display: block; font-size: 0.8rem; margin-bottom: 0.5rem;">Your Message (Public)</label>
                <textarea name="message" rows="2" placeholder="Optional message for Mukesh..."
                          style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0.75rem; color: #fff;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Donation Report</button>
        </form>
    </div>

    <!-- Donors Wall of Fame -->
    @php
        $publishedDonations = \App\Models\Donation::where('is_published', true)->latest()->take(10)->get();
    @endphp

    @if($publishedDonations->count() > 0)
    <div style="margin-top: 3rem; text-align: left;">
        <h3 style="margin-bottom: 2rem; text-align: center; color: #pink;">💝 Supporter Wall of Fame</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
            @foreach($publishedDonations as $dn)
                <div class="glass-card" style="padding: 1.5rem; border: 1px solid rgba(236, 72, 153, 0.2); background: rgba(236, 72, 153, 0.05);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <div style="width: 30px; height: 30px; border-radius: 50%; background: #ec4899; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold;">
                            {{ substr($dn->donor_name, 0, 1) }}
                        </div>
                        <span style="font-weight: bold; color: #fff; font-size: 0.9rem;">{{ $dn->donor_name }}</span>
                    </div>
                    <p style="font-size: 0.8rem; color: #fff; line-height: 1.5; margin-bottom: 1rem;">
                        {{ $dn->admin_thanks_note }}
                    </p>
                    <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 0.5rem; text-align: right;">
                        <span style="font-size: 0.7rem; color: var(--text-muted);">Mukesh Kumar Ray</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div style="margin-top: 2rem;">
        <a href="{{ route('portal.dashboard') }}" style="color: var(--text-muted); font-size: 0.9rem; text-decoration: none;">
            ← Back to Dashboard
        </a>
    </div>
</div>
@endsection
