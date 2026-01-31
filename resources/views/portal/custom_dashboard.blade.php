@extends('portal.layout')

@section('title', 'Dashboard')

@section('content')
<div class="glass-card">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
        <div>
            <h1>Welcome, {{ $user->name }}</h1>
            <p style="color: var(--text-muted);">This is your personalized dashboard for your journey on our platform.</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 0.875rem; color: var(--text-muted);">Role</div>
            <div class="badge badge-viewed" style="font-size: 1rem; padding: 0.4rem 1rem;">{{ $user->custom_role }}</div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Profile Summary Card -->
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
            <h3 style="margin-bottom: 1.5rem;">Profile Summary</h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <span style="color: var(--text-muted);">Age</span>
                    <span style="font-weight: bold; color: #fff;">{{ $user->age ?? 'Not specified' }} Years</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <span style="color: var(--text-muted);">Gender</span>
                    <span style="font-weight: bold; color: #fff;">{{ ucfirst($user->gender) ?? 'Not specified' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <span style="color: var(--text-muted);">Date of Birth</span>
                    <span style="font-weight: bold; color: #fff;">{{ $user->dob ? $user->dob->format('M d, Y') : 'Not specified' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-muted);">Identity</span>
                    <span style="font-weight: bold; color: #4ade80;">Verified User ✓</span>
                </div>
            </div>
            
            <a href="#" class="btn btn-secondary" style="width: 100%; margin-top: 1.5rem; text-align: center; border: 1px dashed rgba(255,255,255,0.1);">Edit Profile (Coming Soon)</a>
        </div>

        <!-- Quick Actions Card -->
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.03);">
            <h3 style="margin-bottom: 1.5rem;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <a href="{{ route('portal.users.search') }}" class="glass-card action-item" style="padding: 1rem; text-align: center; background: rgba(59, 130, 246, 0.1); text-decoration: none;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🔍</div>
                    <div style="font-size: 0.8rem; color: #fff;">Find People</div>
                </a>
                <a href="{{ route('portal.friends.list') }}" class="glass-card action-item" style="padding: 1rem; text-align: center; background: rgba(16, 185, 129, 0.1); text-decoration: none;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">👥</div>
                    <div style="font-size: 0.8rem; color: #fff;">My Friends</div>
                </a>
                <a href="{{ route('portal.chat') }}" class="glass-card action-item" style="padding: 1rem; text-align: center; background: rgba(139, 92, 246, 0.1); text-decoration: none;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">💬</div>
                    <div style="font-size: 0.8rem; color: #fff;">Support Chat</div>
                </a>
                <a href="{{ route('portal.support') }}" class="glass-card action-item" style="padding: 1rem; text-align: center; background: rgba(251, 191, 36, 0.1); text-decoration: none;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">❤️</div>
                    <div style="font-size: 0.8rem; color: #fff;">Donate</div>
                </a>
            </div>
        </div>
    </div>
    
    @include('portal.partials.wall_of_fame')
</div>

<style>
    .action-item {
        transition: transform 0.2s, background 0.2s;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .action-item:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.1) !important;
        border-color: rgba(255,255,255,0.2);
    }
</style>
@endsection
