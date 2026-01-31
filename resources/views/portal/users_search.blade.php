@extends('portal.layout')

@section('title', 'Find Users')

@section('content')
<div class="glass-card">
    <div style="margin-bottom: 2rem;">
        <h1>Find Users</h1>
        <p style="color: var(--text-muted);">Search for other users on the platform to connect and chat.</p>
    </div>

    <div class="glass-card" style="background: rgba(255, 255, 255, 0.03); margin-bottom: 2rem;">
        <form action="{{ route('portal.users.search') }}" method="GET" style="display: flex; gap: 1rem;">
            <input type="text" name="query" value="{{ $query }}" placeholder="Search by name..." required
                   style="flex: 1; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 0.75rem 1.25rem; color: #fff; outline: none;">
            <button type="submit" class="btn btn-primary" style="padding: 0 2rem;">Search</button>
        </form>
    </div>

    @if($query)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @forelse($users as $user)
                <div class="glass-card" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 style="margin: 0;">{{ $user->name }}</h3>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 0.25rem;">
                                <span class="badge" style="font-size: 0.65rem;">
                                    {{ $user->role === 'other' ? $user->custom_role : ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                                @if($user->age)
                                    <span class="badge" style="font-size: 0.65rem; background: rgba(59, 130, 246, 0.1); color: #60a5fa;">{{ $user->age }} yrs</span>
                                @endif
                                @if($user->gender)
                                    <span class="badge" style="font-size: 0.65rem; background: rgba(139, 92, 246, 0.1); color: #a78bfa;">{{ ucfirst($user->gender) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->isFriendsWith($user->id))
                        <div style="display: flex; gap: 0.5rem;">
                            <span class="badge badge-shortlisted" style="width: 100%; text-align: center; padding: 0.75rem;">✓ Friends</span>
                        </div>
                    @elseif(Auth::user()->hasSentRequestTo($user->id))
                        <div style="display: flex; gap: 0.5rem;">
                            <span class="badge badge-viewed" style="width: 100%; text-align: center; padding: 0.75rem;">Request Sent</span>
                        </div>
                    @elseif(Auth::user()->hasPendingRequestFrom($user->id))
                        <a href="{{ route('portal.friend_requests') }}" class="btn btn-secondary" style="width: 100%; padding: 0.75rem;">Respond to Request</a>
                    @else
                        <form action="{{ route('portal.friend_request.send', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">Send Friend Request</button>
                        </form>
                    @endif
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--text-muted);">
                    No users found matching "{{ $query }}"
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection
