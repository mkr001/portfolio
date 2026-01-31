@php
    $wallDonations = \App\Models\Donation::where('is_published', true)->latest()->take(6)->get();
@endphp

@if($wallDonations->count() > 0)
<div style="margin-top: 3rem;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; margin: 0; color: #ec4899;">💝 Community Shoutouts</h2>
        <a href="{{ route('portal.support') }}" style="color: var(--text-muted); font-size: 0.8rem; text-decoration: none;">Support Mukesh →</a>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
        @foreach($wallDonations as $dn)
            <div class="glass-card" style="padding: 1.25rem; background: rgba(236, 72, 153, 0.03); border: 1px solid rgba(236, 72, 153, 0.1); display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #ec4899; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; color: #fff;">
                        {{ substr($dn->donor_name, 0, 1) }}
                    </div>
                    <span style="font-weight: 700; font-size: 0.9rem; color: #fff;">{{ $dn->donor_name }}</span>
                    <span style="margin-left: auto; font-size: 0.7rem; color: #ec4899; font-weight: bold;">DONOR</span>
                </div>
                <p style="font-size: 0.8rem; color: #fff; line-height: 1.5; margin: 0; font-style: italic;">
                    "{{ $dn->admin_thanks_note }}"
                </p>
                <div style="font-size: 0.65rem; color: var(--text-muted); text-align: right; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 0.5rem;">
                    — Mukesh Kumar Ray
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
