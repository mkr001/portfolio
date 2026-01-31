@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">
            Messages & Conversations
        </h1>
        <p class="text-gray-400 mt-2">Chat directly with your portal users.</p>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @forelse($users as $user)
            <a href="{{ route('admin.user_chat', $user->id) }}" class="card p-6 rounded-2xl flex items-center justify-between hover:bg-white/5 transition border border-white/5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                             <h3 class="font-bold text-white">{{ $user->name }}</h3>
                             @if($user->unread_count > 0)
                                <span class="bg-blue-500 text-[10px] font-black uppercase text-white px-2 py-0.5 rounded-full animate-pulse">{{ $user->unread_count }} New</span>
                             @endif
                        </div>
                        <p class="text-xs text-gray-500">{{ $user->email }} • {{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-gray-500 mb-1">Last message</div>
                    <div class="text-sm text-gray-400">{{ $user->chatMessages()->latest()->first()->created_at->diffForHumans() }}</div>
                </div>
            </a>
        @empty
            <div class="p-20 text-center text-gray-500 italic card rounded-2xl">
                No conversations found.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
