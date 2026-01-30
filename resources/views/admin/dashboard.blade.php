@extends('admin.layout')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-bold">Dashboard Overview</h1>
    <p class="text-gray-400 mt-2">Welcome back, Mukesh! Here's what's happening today.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Stat 1 -->
    <div class="card p-8 rounded-3xl shadow-xl">
        <div class="text-gray-400 font-semibold mb-2">Total Messages</div>
        <div class="text-5xl font-black text-blue-500">{{ $stats['contacts'] }}</div>
        <div class="mt-4 text-sm text-gray-500">Inbound inquiries from website</div>
    </div>

    <!-- Stat 2 -->
    <div class="card p-8 rounded-3xl shadow-xl">
        <div class="text-gray-400 font-semibold mb-2">Callback Requests</div>
        <div class="text-5xl font-black text-green-500">{{ $stats['callbacks'] }}</div>
        <div class="mt-4 text-sm text-gray-500">Urgent responses needed</div>
    </div>

    <!-- Stat 3 -->
    <div class="card p-8 rounded-3xl shadow-xl">
        <div class="text-gray-400 font-semibold mb-2">Active Projects</div>
        <div class="text-5xl font-black text-purple-500">{{ $stats['projects'] }}</div>
        <div class="mt-4 text-sm text-gray-500">Displayed on your portfolio</div>
    </div>
</div>

<div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Messages -->
    <div class="card p-8 rounded-3xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Recent Messages</h3>
            <a href="{{ route('admin.contacts') }}" class="text-blue-500 text-sm hover:underline">View All</a>
        </div>
        <div class="space-y-4">
            @forelse($recentContacts as $contact)
                <div class="group border-b border-white/5 pb-4 last:border-0 last:pb-0 relative">
                    <div class="flex justify-between items-start mb-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-white">{{ $contact->name }}</span>
                            @if(!$contact->is_read)
                                <span class="px-2 py-0.5 bg-blue-500 text-[10px] font-black uppercase rounded-full text-white animate-pulse">New</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">{{ $contact->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <p class="text-sm text-gray-400 truncate flex-1 mr-4">{{ $contact->message }}</p>
                        @if(!$contact->is_read)
                            <form action="{{ route('admin.contacts.read', $contact->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold text-blue-400 hover:text-white transition uppercase tracking-widest bg-blue-500/10 px-2 py-1 rounded border border-blue-500/20">Mark Read</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm italic">No recent messages.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Callbacks -->
    <div class="card p-8 rounded-3xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Recent Callbacks</h3>
            <a href="{{ route('admin.callbacks') }}" class="text-green-500 text-sm hover:underline">View All</a>
        </div>
        <div class="space-y-4">
            @forelse($recentCallbacks as $callback)
                <div class="group border-b border-white/5 pb-4 last:border-0 last:pb-0 relative">
                    <div class="flex justify-between items-start mb-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-white">{{ $callback->name }}</span>
                            @if(!$callback->is_read)
                                <span class="px-2 py-0.5 bg-green-500 text-[10px] font-black uppercase rounded-full text-white animate-pulse">Urgent</span>
                            @endif
                        </div>
                        <span class="text-xs text-slate-400 font-mono">{{ $callback->phone }}</span>
                    </div>
                    <div class="flex justify-between items-end">
                        <p class="text-xs text-gray-500">{{ $callback->created_at->diffForHumans() }}</p>
                        @if(!$callback->is_read)
                            <form action="{{ route('admin.callbacks.read', $callback->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[10px] font-bold text-green-400 hover:text-white transition uppercase tracking-widest bg-green-500/10 px-2 py-1 rounded border border-green-500/20">Mark Read</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm italic">No recent callback requests.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection

