@extends('portal.layout')

@section('title', 'Chat with ' . $otherUser->name)

@section('content')
<div class="glass-card" style="height: 80vh; display: flex; flex-direction: column;">
    <div style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('portal.friends.list') }}" style="color: var(--text-muted); text-decoration: none; font-size: 1.25rem; margin-right: 0.5rem;">←</a>
            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #3b82f6); display: flex; align-items: center; justify-content: center; font-weight: bold; color: white;">
                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="margin: 0; font-size: 1.1rem;">{{ $otherUser->name }}</h2>
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                    <p style="margin: 0; font-size: 0.8rem; color: #4ade80;">Active</p>
                </div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div class="badge" style="background: rgba(255,255,255,0.05);">{{ ucfirst(str_replace('_', ' ', $otherUser->role)) }}</div>
            <form action="{{ route('portal.friend.block', $friendship->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to block this user?')">
                @csrf
                <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;">🚫 Block</button>
            </form>
        </div>
    </div>

    <!-- Messages Area -->
    <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        @forelse($messages as $msg)
            @php $isMe = $msg->user_id === Auth::id(); @endphp
            <div style="display: flex; flex-direction: column; {{ $isMe ? 'align-items: flex-end' : 'align-items: flex-start' }}">
                <div style="max-width: 70%; padding: 0.75rem 1rem; border-radius: 15px; font-size: 0.9rem; 
                    {{ $isMe ? 'background: #3b82f6; color: #fff; border-bottom-right-radius: 2px;' : 'background: rgba(255,255,255,0.05); color: #fff; border-bottom-left-radius: 2px; border: 1px solid rgba(255,255,255,0.05);' }}">
                    @if($msg->image_path)
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ Storage::url($msg->image_path) }}" alt="Image" style="max-width: 100%; border-radius: 10px; cursor: pointer;" onclick="window.open(this.src)">
                        </div>
                    @endif
                    @if($msg->message)
                        {{ $msg->message }}
                    @endif
                </div>
                <span style="font-size: 0.7rem; color: var(--text-muted); margin-top: 0.2rem;">
                    {{ $msg->created_at->format('h:i A') }}
                    @if($isMe)
                        <span style="margin-left: 0.3rem;">{{ $msg->is_read ? '✓✓' : '✓' }}</span>
                    @endif
                </span>
            </div>
        @empty
            <div style="text-align: center; color: var(--text-muted); margin-top: 5rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">👋</div>
                <p>No messages here yet.</p>
                <p style="font-size: 0.85rem;">Say hello to {{ $otherUser->name }}!</p>
            </div>
        @endforelse
    </div>

    <!-- Input Area -->
    <div style="padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.1);">
        <form action="{{ route('portal.chat.friend.send', $friendship->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 0.75rem; align-items: center;">
            @csrf
            <div style="position: relative; overflow: hidden; width: 45px; height: 45px; background: rgba(255,255,255,0.05); border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;">
                <span style="font-size: 1.25rem;">📷</span>
                <input type="file" name="image" accept="image/*" style="position: absolute; opacity: 0; cursor: pointer; width: 100%; height: 100%;" onchange="if(this.files[0]) this.parentElement.style.background='#3b82f6'">
            </div>
            <input type="text" name="message" placeholder="Type a message for {{ $otherUser->name }}..." autocomplete="off"
                   style="flex: 1; background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 0.875rem 1.25rem; color: #fff; outline: none; transition: border-color 0.2s;"
                   onfocus="this.parentElement.style.borderColor='rgba(59, 130, 246, 0.5)'">
            <button type="submit" class="btn btn-primary" style="padding: 0 2rem; border-radius: 12px; font-weight: bold; height: 45px;">Send</button>
        </form>
    </div>
</div>

<script>
    // Auto scroll to bottom
    const chatBox = document.getElementById('chat-messages');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
