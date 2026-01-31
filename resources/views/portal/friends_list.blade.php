@extends('portal.layout')

@section('title', 'My Friends')

@section('content')
<div class="glass-card">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1>My Network</h1>
            <p style="color: var(--text-muted);">Connect with your friends and start chatting.</p>
        </div>
        <a href="{{ route('portal.users.search') }}" class="btn btn-primary">🔍 Find More Friends</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($friendships as $friendship)
            @php $friend = $friendship->getOtherUser(Auth::id()); @endphp
            <div class="glass-card user-card" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255,255,255,0.05); transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;" onclick="window.location='{{ route('portal.chat.friend', $friendship->id) }}'">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div style="width: 55px; height: 55px; background: linear-gradient(135deg, #10b981, #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5rem; position: relative;">
                        {{ strtoupper(substr($friend->name, 0, 1)) }}
                        <div style="position: absolute; bottom: 0; right: 0; width: 14px; height: 14px; background: #10b981; border: 2px solid #0f172a; border-radius: 50%;"></div>
                    </div>
                    <div>
                        <h3 style="margin: 0;">{{ $friend->name }}</h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.25rem;">
                            <span class="badge" style="font-size: 0.65rem; background: rgba(255,255,255,0.05);">
                                {{ $friend->role === 'other' ? $friend->custom_role : ucfirst(str_replace('_', ' ', $friend->role)) }}
                            </span>
                            @if($friend->age)
                                <span class="badge" style="font-size: 0.65rem; background: rgba(59, 130, 246, 0.1); color: #60a5fa;">{{ $friend->age }} yrs</span>
                            @endif
                            @if($friend->gender)
                                <span class="badge" style="font-size: 0.65rem; background: rgba(139, 92, 246, 0.1); color: #a78bfa;">{{ ucfirst($friend->gender) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                @php
                    $unreadCount = $friendship->messages()
                        ->where('user_id', '!=', Auth::id())
                        ->where('is_read', false)
                        ->count();
                @endphp

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">
                    <span style="color: var(--text-muted); font-size: 0.85rem;">Click to chat</span>
                    @if($unreadCount > 0)
                        <span style="background: #3b82f6; color: white; border-radius: 12px; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: bold;">{{ $unreadCount }} new messages</span>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem; background: rgba(255,255,255,0.02); border-radius: 20px;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
                <h3 style="color: var(--text-muted);">Your network is empty</h3>
                <p style="color: rgba(255,255,255,0.3);">Start building your professional network by searching for users.</p>
                <a href="{{ route('portal.users.search') }}" class="btn btn-primary" style="margin-top: 1.5rem; display: inline-block;">Start Searching</a>
            </div>
        @endforelse
    </div>
</div>

<style>
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        background: rgba(255,255,255,0.05) !important;
        border-color: rgba(59, 130, 246, 0.3) !important;
    }
</style>
@endsection
