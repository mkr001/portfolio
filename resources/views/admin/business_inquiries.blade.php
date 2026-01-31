@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-green-500">
            Business Inquiries
        </h1>
        <p class="text-gray-400 mt-2">Manage business growth requests and partnerships.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($inquiries as $inquiry)
            <div class="card p-6 rounded-2xl hover:bg-slate-800/50 transition border-l-4 border-green-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <!-- Info -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                             <h3 class="font-bold text-xl text-white">{{ $inquiry->business_name }}</h3>
                             <span class="text-xs text-gray-400 bg-slate-800 px-2 py-1 rounded">by {{ $inquiry->user->name }}</span>
                        </div>
                       
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                                <h4 class="text-xs uppercase text-gray-500 font-bold mb-2">Challenges</h4>
                                <p class="text-gray-300 text-sm italic">"{{ $inquiry->current_challenges }}"</p>
                            </div>
                            <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                                <h4 class="text-xs uppercase text-gray-500 font-bold mb-2">Goals</h4>
                                <p class="text-gray-300 text-sm italic">"{{ $inquiry->goals }}"</p>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 mt-4">
                            Submitted: {{ $inquiry->created_at->format('M d, Y h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col items-end gap-2 w-full md:w-auto">
                        <!-- Status Badge -->
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                            @if($inquiry->status == 'pending') bg-yellow-500/20 text-yellow-500
                            @elseif($inquiry->status == 'reviewed') bg-blue-500/20 text-blue-500
                            @elseif($inquiry->status == 'connected') bg-green-500/20 text-green-500
                            @endif">
                            {{ ucfirst($inquiry->status) }}
                        </span>

                        <!-- Status Change Form -->
                        <form action="{{ route('admin.business_inquiries.status', $inquiry->id) }}" method="POST" class="mt-2">
                            @csrf
                            <div class="flex items-center bg-slate-900 rounded-lg p-1 border border-white/5">
                                <select name="status" class="bg-transparent text-xs text-gray-300 outline-none px-2 py-1 cursor-pointer">
                                    <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $inquiry->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="connected" {{ $inquiry->status == 'connected' ? 'selected' : '' }}>Connected</option>
                                </select>
                                <button type="submit" class="bg-green-600 hover:bg-green-500 text-white text-[10px] uppercase font-bold px-2 py-1 rounded ml-1 transition">
                                    Update
                                </button>
                            </div>
                        </form>
                        
                        <a href="mailto:{{ $inquiry->user->email }}" class="text-xs text-blue-400 hover:text-blue-300 mt-2 flex items-center">
                            ✉️ {{ $inquiry->user->email }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-500 italic text-center py-10 card rounded-2xl">No business inquiries yet.</div>
        @endforelse
    </div>
@endsection
