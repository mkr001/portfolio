<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Portal') }} - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
    @if (!request()->routeIs('portal.login', 'portal.register.post', 'portal.register', 'register', 'register.post'))
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">Portfolio</a>
        <div class="nav-links">
            <a href="{{ route('portal.dashboard') }}" class="nav-link">Dashboard</a>
            <a href="{{ route('portal.chat') }}" class="nav-link">
                💬 Chat
                @if(isset($unreadUserChatCount) && $unreadUserChatCount > 0)
                    <span style="background: #ef4444; color: white; border-radius: 50%; padding: 0.1rem 0.4rem; font-size: 0.7rem; margin-left: 0.2rem;">{{ $unreadUserChatCount }}</span>
                @endif
            </a>
            <a href="{{ route('portal.support') }}" class="nav-link" style="color: #4ade80; font-weight: bold;">❤️ Donate</a>
            @auth
                <a href="#" onclick="document.getElementById('feedback-modal').style.display='flex'" class="nav-link">⭐ Feedback</a>
                @if(Auth::user()->role === 'employer')
                    <a href="{{ route('portal.applicants') }}" class="nav-link">Applicants</a>
                @endif
                <a href="{{ route('portal.logout') }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; text-decoration: none;">Logout</a>
            @else
                <a href="{{ route('portal.login') }}" class="nav-link">Login</a>
                <a href="{{ route('portal.register') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Register</a>
            @endauth
        </div>
    </nav>
    @endif

    <div class="container animate-fade-in">
        @if(session('success'))
            <div style="background: rgba(34, 197, 94, 0.1); color: #4ade80; padding: 1rem; border-radius: 8px; border: 1px solid rgba(34, 197, 94, 0.2); margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: #f87171; padding: 1rem; border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.2); margin-bottom: 2rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

        @auth
            @if(!request()->is('portal/support'))
            <div class="glass-card" style="margin-top: 3rem; background: linear-gradient(to right, rgba(74, 222, 128, 0.05), rgba(59, 130, 246, 0.05)); border: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 2rem;">
                <div style="display: flex; items-center; gap: 1rem;">
                    <span style="font-size: 1.5rem;">❤️</span>
                    <div>
                        <h4 style="margin: 0; color: #fff;">Enjoying the free platform?</h4>
                        <p style="margin: 0.2rem 0 0; font-size: 0.85rem; color: var(--text-muted);">Your donation helps keep the platform free for everybody.</p>
                    </div>
                </div>
                <a href="{{ route('portal.support') }}" class="btn btn-primary" style="padding: 0.5rem 1.5rem; background: #4ade80; color: #000; border: none; font-weight: bold;">Support Mukesh</a>
            </div>
            @endif
        @endauth
    </div>

    <!-- Feedback Modal -->
    <div id="feedback-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(10px); padding: 1rem;">
        <div class="glass-card" style="width: 100%; max-width: 500px; padding: 2rem; position: relative; border: 1px solid rgba(255,255,255,0.1);">
            <button onclick="document.getElementById('feedback-modal').style.display='none'" 
                    style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: #fff; cursor: pointer; font-size: 1.5rem;">&times;</button>
            
            <h2 style="margin-bottom: 2rem; text-align: center;">Share Your Experience</h2>
            
            <form action="{{ route('portal.feedback.submit') }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 1.5rem; text-align: center;">
                    <label style="display: block; margin-bottom: 1rem;">Rating</label>
                    <div style="display: flex; gap: 0.5rem; justify-content: center; font-size: 2rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required style="display: none;">
                            <label for="star{{ $i }}" class="star-label" style="cursor: pointer; color: rgba(255,255,255,0.1); transition: color 0.2s;" data-star="{{ $i }}">★</label>
                        @endfor
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="comment">Your Feedback</label>
                    <textarea name="comment" id="comment" rows="4" required placeholder="Tell us what you think..."
                              style="width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 1rem; color: #fff;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Feedback</button>
            </form>
        </div>
    </div>

    <script>
        // Simple star rating interaction
        const labels = document.querySelectorAll('.star-label');
        labels.forEach(label => {
            label.addEventListener('click', () => {
                const val = parseInt(label.getAttribute('data-star'));
                labels.forEach(l => {
                    const lVal = parseInt(l.getAttribute('data-star'));
                    l.style.color = lVal <= val ? '#fbbf24' : 'rgba(255,255,255,0.1)';
                });
            });
            // Hover effect
            label.addEventListener('mouseover', () => {
                const val = parseInt(label.getAttribute('data-star'));
                labels.forEach(l => {
                    const lVal = parseInt(l.getAttribute('data-star'));
                    if (lVal <= val) l.style.transform = 'scale(1.2)';
                });
            });
            label.addEventListener('mouseout', () => {
                labels.forEach(l => l.style.transform = 'scale(1)');
            });
        });
    </script>
</body>
</html>
