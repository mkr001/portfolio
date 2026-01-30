@extends('admin.layout')

@section('content')
<div class="mb-10">
    <h1 class="text-4xl font-bold text-blue-500">Messages</h1>
    <p class="text-gray-400 mt-2">All messages received from the contact form.</p>
</div>

<div class="card overflow-hidden rounded-3xl">
    <table class="w-full text-left">
        <thead class="bg-white/5 border-b border-white/5">
            <tr>
                <th class="px-8 py-4 text-gray-400 font-semibold">Name</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Email</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Purpose</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Message</th>
                <th class="px-8 py-4 text-gray-400 font-semibold">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($contacts as $contact)
            <tr class="hover:bg-white/5 transition">
                <td class="px-8 py-6 font-bold text-white">{{ $contact->name }}</td>
                <td class="px-8 py-6 text-blue-400 italic">{{ $contact->email }}</td>
                <td class="px-8 py-6">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-blue-500/20 text-blue-400">
                        {{ $contact->purpose }}
                    </span>
                </td>
                <td class="px-8 py-6 text-gray-400 max-w-xs truncate">{{ $contact->message }}</td>
                <td class="px-8 py-6 text-gray-500 text-sm">{{ $contact->created_at->format('M d, Y h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-8 py-20 text-center text-gray-500 italic">No messages found yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $contacts->links() }}
</div>
@endsection
