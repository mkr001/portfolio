@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <a href="{{ route('admin.users') }}" class="text-blue-500 hover:text-blue-400 text-sm flex items-center mb-4">
            ← Back to Users
        </a>
        <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
            Edit User: {{ $user->name }}
        </h1>
        <p class="text-gray-400 mt-2">Update account information or reset password.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-8 rounded-3xl max-w-2xl">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->name) }}" required
                               class="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">User Role</label>
                    <select name="role" required class="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition appearance-none">
                        <option value="job_seeker" {{ $user->role == 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                        <option value="employer" {{ $user->role == 'employer' ? 'selected' : '' }}>Employer / Hiring Manager</option>
                        <option value="business_partner" {{ $user->role == 'business_partner' ? 'selected' : '' }}>Business Partner / Growth</option>
                        <option value="freelance_client" {{ $user->role == 'freelance_client' ? 'selected' : '' }}>Freelance Client (Hire Me)</option>
                    </select>
                </div>

                <!-- Password Reset -->
                <div class="pt-6 border-t border-white/5">
                    <h3 class="text-sm font-bold text-gray-300 mb-4">Reset Password</h3>
                    <p class="text-xs text-gray-500 mb-4 italic">Leave blank if you don't want to change the password.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">New Password</label>
                            <input type="password" name="password" 
                                   class="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3 text-white outline-none focus:border-blue-500 transition">
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-bold py-4 rounded-xl shadow-lg transition uppercase tracking-widest text-xs">
                        Update User Account
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
