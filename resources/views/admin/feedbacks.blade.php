@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">
            User Feedback
        </h1>
        <p class="text-gray-400 mt-2">Manage and moderate feedback from your users.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($feedbacks as $feedback)
            <div class="card p-6 rounded-3xl border border-white/5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-500 to-orange-600 flex items-center justify-center font-bold text-white">
                                {{ substr($feedback->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-sm">{{ $feedback->name }}</h3>
                                <p class="text-[10px] text-gray-500 italic">{{ $feedback->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex text-yellow-500 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $feedback->rating ? '' : 'text-gray-600' }}">★</span>
                            @endfor
                        </div>
                    </div>
                    
                    <p class="text-gray-300 text-sm italic leading-relaxed mb-6">
                        "{{ $feedback->comment }}"
                    </p>
                </div>

                <div class="pt-4 border-t border-white/5 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold uppercase tracking-widest
                            @if($feedback->status == 'pending') text-yellow-500
                            @elseif($feedback->status == 'approved') text-green-500
                            @else text-gray-500
                            @endif">
                            Status: {{ $feedback->status }}
                        </span>
                        
                        <div class="flex gap-2">
                             <form action="{{ route('admin.feedbacks.status', $feedback->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="{{ $feedback->status == 'approved' ? 'hidden' : 'approved' }}">
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-lg border transition
                                    {{ $feedback->status == 'approved' ? 'border-gray-500/20 text-gray-400 hover:bg-gray-500/10' : 'border-green-500/20 text-green-400 hover:bg-green-500/10' }}">
                                    {{ $feedback->status == 'approved' ? 'Hide' : 'Approve' }}
                                </button>
                             </form>

                             <form action="{{ route('admin.feedbacks.delete', $feedback->id) }}" method="POST" onsubmit="return confirm('Delete this feedback?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-lg border border-red-500/20 text-red-400 hover:bg-red-500/10 transition">
                                    Delete
                                </button>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full p-20 text-center text-gray-500 italic card rounded-2xl">
                No feedback received yet.
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $feedbacks->links() }}
    </div>
@endsection
