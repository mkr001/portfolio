@extends('admin.layout')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">
        System Settings
    </h1>
    <p class="text-gray-400 mt-2">Manage global configurations and donation details.</p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-2xl">
    <div class="card p-8 rounded-3xl border border-white/5">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest">Donation UPI ID</label>
                <input type="text" name="upi_id" value="{{ $settings['upi_id'] ?? '' }}" 
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                <p class="text-[10px] text-gray-500 italic">This UPI ID will be used for the automatic QR generator.</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest">Custom QR Code Image (Optional)</label>
                @if(isset($settings['upi_qr_code']))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $settings['upi_qr_code']) }}" alt="Current QR" class="w-32 h-32 rounded-lg border border-white/10">
                        <p class="text-[10px] text-green-500 mt-1">✓ Custom QR is currently active</p>
                    </div>
                @endif
                <input type="file" name="upi_qr_code" accept="image/*"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                <p class="text-[10px] text-gray-500 italic">Upload your own QR image if the automatic donor scanner fails.</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest">Donation Link (Buy Me a Coffee)</label>
                <input type="url" name="donation_link" value="{{ $settings['donation_link'] ?? '' }}" 
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                <p class="text-[10px] text-gray-500 italic">Full URL for your external donation page.</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest">Total Donations Collected (₹)</label>
                <input type="number" name="total_donations" value="{{ $settings['total_donations'] ?? '0' }}" 
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                <p class="text-[10px] text-gray-500 italic">Manually track and update the total amount collected so far.</p>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-xs">
                    Save All Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
