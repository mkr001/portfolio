@extends('portal.layout')

@section('title', 'Chat with Admin')

@section('content')
<div class="glass-card" style="height: 80vh; display: flex; flex-direction: column;">
    <div style="padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; gap: 1rem;">
        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white">M</div>
        <div>
            <h2 style="margin: 0; font-size: 1.1rem;">Chat with Mukesh (Admin)</h2>
            <p style="margin: 0; font-size: 0.8rem; color: #4ade80;">● Online (Replies usually within a few hours)</p>
        </div>
    </div>

    <!-- Messages Area -->
    <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
        @forelse($messages as $msg)
            <div style="display: flex; flex-direction: column; {{ $msg->is_from_admin ? 'align-items: flex-start' : 'align-items: flex-end' }}">
                <div style="max-width: 70%; padding: 0.75rem 1rem; border-radius: 15px; font-size: 0.9rem; 
                    {{ $msg->is_from_admin ? 'background: rgba(255,255,255,0.05); color: #fff; border-bottom-left-radius: 2px;' : 'background: #3b82f6; color: #fff; border-bottom-right-radius: 2px;' }}">
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
                </span>
            </div>
        @empty
            <div style="text-align: center; color: var(--text-muted); margin-top: 2rem;">
                <p>No messages yet. Say hello to Mukesh!</p>
            </div>
        @endforelse
    </div>

    <!-- Input Area -->
    <div style="padding: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
        <form action="{{ route('portal.chat.send') }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 0.75rem; align-items: center;">
            @csrf
            <div style="position: relative; overflow: hidden; width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;">
                <span style="font-size: 1.25rem;">📷</span>
                <input type="file" name="image" accept="image/*" style="position: absolute; opacity: 0; cursor: pointer; width: 100%; height: 100%;" onchange="if(this.files[0]) this.parentElement.style.background='#3b82f6'">
            </div>
            <input type="text" name="message" placeholder="Type your message..." autocomplete="off"
                   style="flex: 1; background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; outline: none;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Send</button>
        </form>
    </div>
</div>

<script>
    // Auto scroll to bottom
    const chatBox = document.getElementById('chat-messages');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endsection
