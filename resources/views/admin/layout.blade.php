<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Mukesh Portfolio</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Outfit', sans-serif; background-color: #020617; color: #f1f5f9; }
    .card { background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); }
    .nav-link:hover { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .nav-link.active { background: rgba(59, 130, 246, 0.2); color: #3b82f6; border-right: 3px solid #3b82f6; }
    
    /* Turbo Progress Bar */
    .turbo-progress-bar {
        background: linear-gradient(to right, #3b82f6, #a855f7);
        height: 3px;
    }
</style>
<!-- Turbo Drive -->
<script type="module">
    import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
</script>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-slate-950 border-r border-white/5 flex flex-col pt-8">
        <div class="px-6 mb-10 text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
            Admin Panel
        </div>
        
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="mr-3">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.contacts') }}" class="nav-link flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.contacts') ? 'active' : '' }}">
                <div class="flex items-center">
                    <span class="mr-3">✉️</span> Messages
                </div>
                @if($unreadContactsCount > 0)
                    <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadContactsCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.callbacks') }}" class="nav-link flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.callbacks') ? 'active' : '' }}">
                <div class="flex items-center">
                    <span class="mr-3">📞</span> Callbacks
                </div>
                @if($unreadCallbacksCount > 0)
                    <span class="bg-green-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadCallbacksCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.career_requests') }}" class="nav-link flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.career_requests') ? 'active' : '' }}">
                <div class="flex items-center">
                    <span class="mr-3">🚀</span> Job Portal
                </div>
                @if($unreadJobCount > 0)
                    <span class="bg-orange-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadJobCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.users') }}" class="nav-link flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <span class="mr-3">👥</span> Users
            </a>

            <a href="{{ route('admin.chats') }}" class="nav-link flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.chats', 'admin.user_chat') ? 'active' : '' }}">
                <div class="flex items-center">
                    <span class="mr-3">💬</span> Chats
                </div>
                @if($unreadAdminChatCount > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadAdminChatCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.feedbacks') }}" class="nav-link flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.feedbacks') ? 'active' : '' }}">
                <span class="mr-3">⭐</span> Feedback
            </a>

            <a href="{{ route('admin.settings') }}" class="nav-link flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <span class="mr-3">⚙️</span> Settings
            </a>

            <a href="{{ route('admin.business_inquiries') }}" class="nav-link flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.business_inquiries') ? 'active' : '' }}">
                <div class="flex items-center">
                    <span class="mr-3">🤝</span> Business
                </div>
                @if($unreadBusinessCount > 0)
                    <span class="bg-cyan-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadBusinessCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.freelance_inquiries') }}" class="nav-link flex items-center justify-between px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.freelance_inquiries') ? 'active' : '' }}">
                <div class="flex items-center">
                    <span class="mr-3">💻</span> Freelance
                </div>
                @if($unreadFreelanceCount > 0)
                    <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadFreelanceCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.projects') }}" class="nav-link flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.projects') ? 'active' : '' }}">
                <span class="mr-3">💼</span> Projects
            </a>
            <div class="pt-10 border-t border-white/5 px-4 space-y-2">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white transition">
                    <span class="mr-3">🏠</span> View Website
                </a>
                <a href="{{ route('admin.logout') }}" class="w-full flex items-center px-4 py-3 text-red-400/70 hover:text-red-400 transition">
                    <span class="mr-3">🚪</span> Logout
                </a>
            </div>

        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 overflow-y-auto">
        @yield('content')
    </div>

</body>
</html>
