<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In – TravelScape</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const iconClass = currentTheme === 'dark' ? 'fa-sun' : 'fa-moon';
            const btnHtml = `
                <button id="themeToggleBtn" aria-label="Toggle theme" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0.5rem 0.9rem; display: inline-flex; align-items: center; justify-content: center; font-size: 1.15rem; transition: all 0.2s; font-family: inherit; outline: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class="fa-solid ${iconClass}"></i>
                </button>
            `;
            let injected = false;
            const navInner = document.querySelector('.navbar-inner');
            if (navInner) {
                const toggleDiv = document.createElement('div');
                toggleDiv.className = 'theme-toggle-item';
                toggleDiv.innerHTML = btnHtml;
                navInner.appendChild(toggleDiv);
                injected = true;
            }
            if (!injected) {
                const floatingDiv = document.createElement('div');
                floatingDiv.style.position = 'fixed';
                floatingDiv.style.bottom = '2rem';
                floatingDiv.style.right = '2rem';
                floatingDiv.style.zIndex = '9999';
                floatingDiv.style.background = 'var(--white)';
                floatingDiv.style.border = '1px solid var(--border)';
                floatingDiv.style.boxShadow = 'var(--shadow-lg)';
                floatingDiv.style.borderRadius = '50%';
                floatingDiv.style.width = '48px';
                floatingDiv.style.height = '48px';
                floatingDiv.style.display = 'flex';
                floatingDiv.style.alignItems = 'center';
                floatingDiv.style.justifyContent = 'center';
                floatingDiv.innerHTML = btnHtml;
                document.body.appendChild(floatingDiv);
            }
            const btn = document.getElementById('themeToggleBtn');
            if (btn) {
                btn.addEventListener('click', function() {
                    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                    const newTheme = isDark ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    const icon = btn.querySelector('i');
                    if (newTheme === 'dark') {
                        icon.className = 'fa-solid fa-sun';
                    } else {
                        icon.className = 'fa-solid fa-moon';
                    }
                });
            }
        });
    </script>
    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 2rem;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .auth-card {
            background: white;
            border-radius: var(--radius, 12px);
            box-shadow: var(--shadow-lg, 0 10px 25px -5px rgba(0, 0, 0, 0.1));
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            text-align: center;
        }
        .auth-logo {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .auth-logo i { color: var(--primary, #f97316); }
        .auth-logo-text { color: var(--text, #1f2937); }
        .auth-logo-text span { color: var(--primary, #f97316); }
        .auth-card p {
            color: var(--text-muted, #6b7280);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        .auth-form {
            text-align: left;
        }
        .auth-form .form-group {
            margin-bottom: 1.25rem;
            display: flex;
            flex-direction: column;
        }
        .auth-form label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text, #1f2937);
        }
        .input-icon-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon-wrap i {
            position: absolute;
            left: 1rem;
            color: #9ca3af;
        }
        .input-icon-wrap input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: var(--radius-sm, 6px);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-icon-wrap input:focus {
            border-color: var(--primary, #f97316);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        .auth-btn {
            width: 100%;
            background: var(--primary, #f97316);
            color: white;
            border: none;
            padding: 0.85rem;
            border-radius: var(--radius-sm, 6px);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .auth-btn:hover { 
            background: #ea580c; 
            transform: translateY(-2px); 
        }
        .auth-links { margin-top: 1.5rem; font-size: 0.9rem; color: #4b5563; }
        .auth-links a { color: var(--primary, #f97316); text-decoration: none; font-weight: 600; }
        .auth-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-page">
    <div class="auth-card fade-in">
        <a href="{{ route('home') }}" style="text-decoration:none;">
            <div class="auth-logo">
                <i class="fa-solid fa-compass"></i>
                <span class="auth-logo-text">Travel<span>Scape</span></span>
            </div>
        </a>
        @if(session('success'))
            <div style="background:#e6faf7;border:1px solid #a7f3d0;border-radius:10px;padding:0.75rem 1rem;margin-bottom:1.5rem;color:#047857;font-size:0.85rem;display:flex;align-items:center;gap:0.6rem;text-align:left;" class="fade-in">
                <i class="fa-solid fa-circle-check" style="font-size:1rem"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <span class="error-msg" style="color: #FF5A30; font-size: 0.8rem; margin-top: 0.35rem; display: block; font-weight: 500;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                @error('password')
                    <span class="error-msg" style="color: #FF5A30; font-size: 0.8rem; margin-top: 0.35rem; display: block; font-weight: 500;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; font-size:0.85rem;">
                <label style="display:flex; align-items:center; gap:0.4rem; font-weight:normal; margin:0; cursor:pointer; color:#4b5563;">
                    <input type="checkbox" name="remember" id="remember" style="width:auto; cursor:pointer;"> Remember me
                </label>
                <a href="#" style="color:var(--primary, #FF5A30); text-decoration:none; font-weight:500;">Forgot password?</a>
            </div>

            <button type="submit" class="auth-btn">
                <i class="fa-solid fa-right-to-bracket"></i> Sign In
            </button>
        </form>

        <div class="auth-links">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
</div>

</body>
</html>
