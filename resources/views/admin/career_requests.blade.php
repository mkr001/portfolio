@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
            Job Portal Management
        </h1>
        <p class="text-gray-400 mt-2">Manage all registered job seekers and employers.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Job Seekers Column (Wider) -->
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-orange-400 mb-6 flex items-center">
                <span class="bg-orange-500/10 p-2 rounded-lg mr-3">👨‍💻</span> Job Applications ({{ $applications->count() }})
            </h2>
            
            <div class="space-y-4">
                @forelse($applications as $app)
                    <div class="card p-6 rounded-2xl hover:bg-slate-800/50 transition border-l-4 border-orange-500">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <!-- Info -->
                            <div>
                                <h3 class="font-bold text-lg text-white">
                                    {{ $app->user->name }}
                                    <span class="ml-2 text-xs bg-slate-700 text-slate-300 px-2 py-0.5 rounded-full">{{ $app->job_title }}</span>
                                </h3>
                                <div class="text-sm text-blue-400 hover:text-blue-300 transition mt-1">
                                    {{ $app->user->email }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Applied: {{ $app->created_at->format('M d, Y h:i A') }} ({{ $app->created_at->diffForHumans() }})
                                </div>
                                <div class="mt-2 text-xs">
                                    Views by Employers: <span class="font-mono text-white">{{ $app->views }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col items-end gap-2 w-full md:w-auto">
                                <!-- Status Badge -->
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                    @if($app->status == 'pending') bg-yellow-500/20 text-yellow-500
                                    @elseif($app->status == 'shortlisted') bg-green-500/20 text-green-500
                                    @elseif($app->status == 'interview') bg-blue-500/20 text-blue-500
                                    @elseif($app->status == 'rejected') bg-red-500/20 text-red-500
                                    @endif">
                                    {{ ucfirst($app->status) }}
                                </span>

                                <!-- Buttons -->
                                <div class="flex gap-2 mt-2">
                                    <a href="{{ route('admin.career_requests.download', $app->id) }}" class="text-xs bg-slate-700 hover:bg-slate-600 text-white px-3 py-2 rounded-lg font-medium transition flex items-center">
                                        <span class="mr-1">📄</span> CV
                                    </a>
                                </div>

                                <!-- Status Change Form -->
                                <form action="{{ route('admin.career_requests.status', $app->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <div class="flex items-center bg-slate-900 rounded-lg p-1 border border-white/5">
                                        <select name="status" class="bg-transparent text-xs text-gray-300 outline-none px-2 py-1 cursor-pointer">
                                            <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="shortlisted" {{ $app->status == 'shortlisted' ? 'selected' : '' }}>Shortlist</option>
                                            <option value="interview" {{ $app->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                            <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                        </select>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-[10px] uppercase font-bold px-2 py-1 rounded ml-1 transition">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 italic text-center py-10 card rounded-2xl">No job applications yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Employers Column (Narrower) -->
        <div>
            <h2 class="text-2xl font-bold text-purple-400 mb-6 flex items-center">
                <span class="bg-purple-500/10 p-2 rounded-lg mr-3">🏢</span> Employers ({{ $employers->count() }})
            </h2>

            <div class="space-y-4">
                @forelse($employers as $emp)
                    <div class="card p-5 rounded-2xl hover:bg-slate-800/50 transition border-l-4 border-purple-500">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-md text-white">{{ $emp->name }}</h3>
                                <div class="text-sm text-gray-400">{{ $emp->email }}</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            Joined: {{ $emp->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 italic text-center py-10 card rounded-2xl">No employers registered yet.</div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
