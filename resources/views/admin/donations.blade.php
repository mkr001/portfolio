@extends('admin.layout')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-600">
        Donation Reports & Recognition
    </h1>
    <p class="text-gray-400 mt-2">Personalize thank you notes for your supporters.</p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 gap-6">
    @forelse($donations as $donation)
        <div class="card p-8 rounded-3xl border {{ $donation->is_published ? 'border-white/5' : 'border-pink-500/30 bg-pink-500/5' }}">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center font-bold text-white text-xl">
                        {{ substr($donation->donor_name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $donation->donor_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $donation->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-black text-pink-500">₹{{ number_format($donation->amount ?? 0) }}</div>
                    <div class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $donation->transaction_id ?? 'No Trans. ID' }}</div>
                </div>
            </div>

            <div class="mb-8">
                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Donor's Message</label>
                <p class="text-gray-300 italic">"{{ $donation->message ?? 'No message provided.' }}"</p>
            </div>

                <div class="flex justify-between items-center mt-6">
                    <form action="{{ route('admin.donations.thanks', $donation->id) }}" method="POST" class="flex-1 mr-4 space-y-4">
                        @csrf
                        <div>
                            <label class="text-[10px] font-bold text-pink-400 uppercase tracking-widest mb-2 block">Your Thank You Note (Will be public)</label>
                            <textarea name="admin_thanks_note" rows="2" required 
                                      placeholder="Write a personal thank you note..."
                                      class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-pink-500 transition">{{ $donation->admin_thanks_note }}</textarea>
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-pink-600 hover:bg-pink-500 text-white font-bold px-6 py-2 rounded-xl transition uppercase tracking-widest text-[10px]">
                                {{ $donation->is_published ? 'Update Note' : 'Publish Note' }}
                            </button>
                            <span class="text-[10px] font-bold uppercase tracking-widest flex items-center {{ $donation->is_published ? 'text-green-500' : 'text-yellow-500' }}">
                                ● {{ $donation->is_published ? 'Published on Website' : 'Pending Review' }}
                            </span>
                        </div>
                    </form>

                    <form action="{{ route('admin.donations.delete', $donation->id) }}" method="POST" onsubmit="return confirm('Permanently delete this donation record?')" class="self-end pb-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-400 text-[10px] font-bold uppercase tracking-widest">
                            Delete Record
                        </button>
                    </form>
                </div>
        </div>
    @empty
        <div class="p-20 text-center text-gray-500 italic card rounded-2xl">
            No donation reports found yet.
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $donations->links() }}
</div>
@endsection
