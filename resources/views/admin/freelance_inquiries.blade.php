@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">
            Freelance Requests
        </h1>
        <p class="text-gray-400 mt-2">Manage freelance projects and client timelines.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($inquiries as $inquiry)
            <div class="card p-6 rounded-2xl hover:bg-slate-800/50 transition border-l-4 border-indigo-500">
                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                    <!-- Info -->
                    <div class="flex-1 w-full">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-xl text-white">{{ $inquiry->project_title }}</h3>
                            <span class="text-xs text-gray-400 bg-slate-800 px-2 py-1 rounded">Client: {{ $inquiry->user->name }}</span>
                        </div>
                        <div class="text-sm text-blue-400 hover:text-blue-300 transition mt-1">
                            {{ $inquiry->user->email }}
                        </div>
                       
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5 mt-4">
                            <h4 class="text-xs uppercase text-gray-500 font-bold mb-2">Project Details</h4>
                            <p class="text-gray-300 text-sm whitespace-pre-line">{{ $inquiry->project_description }}</p>
                            @if($inquiry->budget_range)
                                <div class="mt-2 text-xs font-mono text-green-400">Budget: {{ $inquiry->budget_range }}</div>
                            @endif
                        </div>

                        <!-- Admin Controls -->
                        <div class="mt-4 bg-indigo-500/5 border border-indigo-500/20 p-4 rounded-xl">
                            <h4 class="text-sm font-bold text-indigo-400 mb-2">Project Management</h4>
                            <form action="{{ route('admin.freelance_inquiries.status', $inquiry->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @csrf
                                <div>
                                    <label class="text-xs text-gray-500 block mb-1">Status</label>
                                    <select name="status" class="w-full bg-slate-900 border border-white/10 rounded px-2 py-1 text-sm text-white focus:border-indigo-500 outline-none">
                                        <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                        <option value="accepted" {{ $inquiry->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                        <option value="completed" {{ $inquiry->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="rejected" {{ $inquiry->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs text-green-500 block mb-1">Estimated Completion Date</label>
                                    <input type="date" name="estimated_completion_date" value="{{ $inquiry->estimated_completion_date ? $inquiry->estimated_completion_date->format('Y-m-d') : '' }}" class="w-full bg-slate-900 border border-white/10 rounded px-2 py-1 text-sm text-white focus:border-green-500 outline-none">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-xs text-gray-500 block mb-1">Notes for Client</label>
                                    <textarea name="admin_notes" rows="2" class="w-full bg-slate-900 border border-white/10 rounded px-2 py-1 text-sm text-white focus:border-indigo-500 outline-none" placeholder="Add details about timeline, requirements, or next steps...">{{ $inquiry->admin_notes }}</textarea>
                                </div>
                                <div class="md:col-span-2 text-right">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold px-4 py-2 rounded transition">
                                        Update Project Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-gray-500 italic text-center py-10 card rounded-2xl">No freelance requests yet.</div>
        @endforelse
    </div>
@endsection
