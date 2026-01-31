@extends('admin.layout')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.chats') }}" class="text-blue-500 hover:text-blue-400 text-sm flex items-center mb-2">
                ← Back to Messages
            </a>
            <h1 class="text-3xl font-black text-white">Chat with {{ $user->name }}</h1>
        </div>
        <div class="text-right">
            <span class="px-3 py-1 bg-white/5 rounded-full text-[10px] font-bold uppercase tracking-widest text-gray-400 border border-white/10">
                User ID: #{{ $user->id }}
            </span>
        </div>
    </div>

    <div class="card flex flex-col rounded-3xl overflow-hidden border border-white/5" style="height: 70vh;">
        <!-- Chat Area -->
        <div id="admin-chat-box" class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-950/20">
            @foreach($messages as $msg)
                <div class="flex flex-col {{ $msg->is_from_admin ? 'items-end' : 'items-start' }}">
                    <div class="max-w-[75%] p-4 rounded-2xl text-sm 
                        {{ $msg->is_from_admin ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white/5 text-gray-200 border border-white/5 rounded-tl-none' }}">
                        {{ $msg->message }}
                    </div>
                    <span class="text-[10px] text-gray-500 mt-1 uppercase tracking-tighter">
                        {{ $msg->created_at->format('M d, h:i A') }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white/5 border-t border-white/5">
            <form action="{{ route('admin.chats.send', $user->id) }}" method="POST" class="flex gap-4">
                @csrf
                <input type="text" name="message" placeholder="Type your response to {{ $user->name }}..." required autocomplete="off"
                       class="flex-1 bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-indigo-500 transition">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 rounded-xl transition uppercase tracking-widest text-xs">
                    Send
                </button>
            </form>
        </div>
    </div>

    <script>
        const box = document.getElementById('admin-chat-box');
        box.scrollTop = box.scrollHeight;
    </script>
@endsection
