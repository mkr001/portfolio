<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Mukesh Portfolio</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Outfit', sans-serif; background-color: #020617; color: #f1f5f9; }
</style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Admin Secure</h1>
            <p class="text-gray-500 mt-2">Enter your credentials to manage your empire.</p>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-xl border border-white/10 p-10 rounded-[2.5rem] shadow-2xl">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl text-sm font-bold text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-400 text-sm font-semibold mb-2 px-1">Password</label>
                    <input type="password" name="password" required autofocus
                        class="w-full bg-slate-950 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition text-lg tracking-widest">
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 rounded-2xl shadow-xl shadow-purple-900/20 hover:scale-[1.02] active:scale-95 transition-all text-lg">
                    Access Dashboard
                </button>
            </form>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-white transition text-sm font-medium">← Back to Portfolio</a>
        </div>
    </div>

</body>
</html>
