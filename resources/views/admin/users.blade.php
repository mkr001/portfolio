@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
            User Management
        </h1>
        <p class="text-gray-400 mt-2">View and manage all registered portal users.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="card overflow-hidden rounded-2xl border border-white/5">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 text-gray-400 text-xs uppercase tracking-widest font-bold">
                    <th class="p-4">User</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Joined</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                    <tr class="hover:bg-white/5 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center font-bold text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                @if($user->role == 'job_seeker') bg-orange-500/20 text-orange-400
                                @elseif($user->role == 'employer') bg-green-500/20 text-green-400
                                @elseif($user->role == 'business_partner') bg-cyan-500/20 text-cyan-400
                                @elseif($user->role == 'freelance_client') bg-indigo-500/20 text-indigo-400
                                @else bg-slate-500/20 text-slate-400
                                @endif border border-current">
                                {{ str_replace('_', ' ', $user->role) }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-400">
                            {{ $user->email }}
                        </td>
                        <td class="p-4 text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="p-4 text-right flex justify-end gap-2">
                            <a href="{{ route('admin.user_chat', $user->id) }}" class="text-indigo-400 hover:text-indigo-300 text-xs font-bold uppercase tracking-widest bg-indigo-500/10 px-3 py-1 rounded-lg border border-indigo-500/20 transition">
                                Chat
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-400 hover:text-blue-300 text-xs font-bold uppercase tracking-widest bg-blue-500/10 px-3 py-1 rounded-lg border border-blue-500/20 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete all user data (CVs, inquiries, etc.)');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-bold uppercase tracking-widest bg-red-500/10 px-3 py-1 rounded-lg border border-red-500/20 transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-20 text-center text-gray-500 italic">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
