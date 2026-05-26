<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account – TravelScape</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            max-width: 440px;
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
        .auth-logo i { color: var(--primary, #FF5A30); }
        .auth-logo-text { color: var(--text, #1c1c2e); }
        .auth-logo-text span { color: var(--primary, #FF5A30); }
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
            color: var(--text, #1c1c2e);
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
            border-color: var(--primary, #FF5A30);
            box-shadow: 0 0 0 3px rgba(255, 90, 48, 0.1);
        }
        .auth-btn {
            width: 100%;
            background: var(--primary, #FF5A30);
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
            background: var(--primary-dark, #e04420); 
            transform: translateY(-2px); 
            box-shadow: 0 4px 14px rgba(255, 90, 48, 0.3);
        }
        .auth-links { margin-top: 1.5rem; font-size: 0.9rem; color: #4b5563; }
        .auth-links a { color: var(--primary, #FF5A30); text-decoration: none; font-weight: 600; }
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
        <p>Create an account to track recommendations and verify booking history!</p>

        <form action="{{ route('register.post') }}" method="POST" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="name" name="name" placeholder="e.g. Ishan Pradhan" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                @error('name')
                    <span class="error-msg" style="color: #FF5A30; font-size: 0.8rem; margin-top: 0.35rem; display: block; font-weight: 500;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="email">
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
                    <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="new-password">
                </div>
                @error('password')
                    <span class="error-msg" style="color: #FF5A30; font-size: 0.8rem; margin-top: 0.35rem; display: block; font-weight: 500;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-icon-wrap">
                    <i class="fa-solid fa-lock-open"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="auth-btn">
                <i class="fa-solid fa-user-plus"></i> Create Account
            </button>
        </form>

        <div class="auth-links">
            Already have an account? <a href="{{ route('login') }}">Sign In</a>
        </div>
    </div>
</div>

</body>
</html>
