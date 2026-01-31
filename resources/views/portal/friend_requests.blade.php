@extends('portal.layout')

@section('title', 'Friend Requests')

@section('content')
<div class="glass-card">
    <div style="margin-bottom: 2rem;">
        <h1>Friend Requests</h1>
        <p style="color: var(--text-muted);">Manage incoming requests to connect.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
        @forelse($requests as $request)
            <div class="glass-card" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #fbbf24, #f59e0b); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem;">
                        {{ strtoupper(substr($request->sender->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 1.1rem;">{{ $request->sender->name }}</h3>
                        <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">{{ $request->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <form action="{{ route('portal.friend_request.accept', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; background: #10b981; border: none;">Accept</button>
                    </form>
                    <form action="{{ route('portal.friend_request.reject', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; background: #ef4444; border: none; color: white;">Reject</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem; background: rgba(255,255,255,0.02); border-radius: 20px; border: 1px dashed rgba(255,255,255,0.1);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔔</div>
                <h3 style="color: var(--text-muted);">No pending friend requests</h3>
                <p style="color: rgba(255,255,255,0.3);">When people want to connect with you, they'll appear here.</p>
                <a href="{{ route('portal.users.search') }}" class="btn btn-primary" style="margin-top: 1.5rem; display: inline-block;">Find people to connect</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
