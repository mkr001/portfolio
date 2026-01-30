@extends('admin.layout')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-bold text-green-500">Callback Requests</h1>
    <p class="text-gray-400 mt-2">People who want you to call them back.</p>
</div>

<div class="card overflow-hidden rounded-3xl">
    <table class="w-full text-left">
        <thead class="bg-white/5 border-b border-white/5">
            <tr>
                <th class="px-8 py-4 text-gray-400 font-semibold">Name</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Phone</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Email</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Purpose</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($callbacks as $callback)
            <tr class="hover:bg-white/5 transition">
                <td class="px-8 py-6 font-bold text-white">{{ $callback->name }}</td>
                <td class="px-8 py-6 text-green-400 font-mono">{{ $callback->phone }}</td>
                <td class="px-8 py-6 text-gray-400">{{ $callback->email }}</td>
                <td class="px-8 py-6">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-green-500/20 text-green-400">
                        {{ $callback->purpose }}
                    </span>
                </td>
                <td class="px-8 py-6 text-gray-500 text-sm">{{ $callback->created_at->format('M d, Y h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-8 py-20 text-center text-gray-500 italic">No callbacks requested yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $callbacks->links() }}
</div>
@endsection
