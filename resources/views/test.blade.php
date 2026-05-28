<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Inspector Console – TravelScape</title>
    <meta name="description" content="TravelScape SQLite Database Logins Inspector. Access restricted.">
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
        .test-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 4.5rem 1.5rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid var(--secondary);
        }
        [data-theme="dark"] .test-header {
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
        }
        .test-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(26, 115, 232, 0.15) 0%, transparent 50%);
            pointer-events: none;
        }
        .test-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #00C9A7;
            padding: 0.4rem 1.2rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }
        .test-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }
        .test-header h1 span {
            color: var(--secondary);
        }
        .test-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.15rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: -2.5rem auto 4rem;
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
        }
        .glass-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            padding: 2.5rem;
        }
        .console-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }
        .status-indicator {
            display: flex;
            align-items: center;
            gap: 0.60rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
        }
        .status-dot {
            width: 10px;
            height: 10px;
            background-color: var(--secondary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px var(--secondary);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(26, 115, 232, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(26, 115, 232, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(26, 115, 232, 0); }
        }
        
        /* Interactive Credentials Table Styling */
        .cred-table-wrap {
            overflow-x: auto;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            margin-top: 1.5rem;
            background: var(--bg);
            box-shadow: var(--shadow);
        }
        .cred-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.88rem;
        }
        .cred-table th {
            background: var(--border);
            padding: 1rem;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            font-size: 0.73rem;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .cred-table td {
            padding: 1.1rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            background: var(--white);
            vertical-align: middle;
        }
        .cred-table tr:last-child td {
            border-bottom: none;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary), #00C9A7);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .badge-id {
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text-muted);
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.8rem;
        }
        .hash-box {
            font-family: monospace;
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 0.3rem 0.5rem;
            border-radius: 6px;
            font-size: 0.78rem;
            color: #b91c1c;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        [data-theme="dark"] .hash-box {
            color: #f87171;
        }
        .hash-box:hover {
            max-width: none;
            color: var(--primary);
            border-color: var(--primary);
        }
        .badge-null {
            color: var(--text-muted);
            font-style: italic;
            font-size: 0.8rem;
            opacity: 0.75;
        }
        .badge-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            white-space: nowrap;
        }
        .badge-date strong {
            color: var(--text);
        }
        
        .btn-table-action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.85rem;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-family: inherit;
            text-decoration: none;
        }
        .btn-impersonate {
            background: var(--primary);
            color: white;
            box-shadow: 0 3px 8px rgba(255,90,48,0.15);
        }
        .btn-impersonate:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 5px 12px rgba(255,90,48,0.25);
        }
        .btn-verify {
            background: var(--secondary);
            color: white;
            box-shadow: 0 3px 8px rgba(26,115,232,0.15);
        }
        .btn-verify:hover {
            background: #1557b0;
            transform: translateY(-1px);
            box-shadow: 0 5px 12px rgba(26,115,232,0.25);
        }
        
        /* Interactive Verification Form Container */
        .inline-verify-panel {
            background: var(--bg);
            border: 1.5px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 1.25rem;
            margin-top: 0.75rem;
            display: none;
            animation: slideDown 0.3s cubic-bezier(0.175, 0.885, 0.32, 1) both;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .verify-form {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .verify-input-group {
            display: flex;
            align-items: center;
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        .verify-input-group i {
            position: absolute;
            left: 0.85rem;
            color: var(--text-muted);
            font-size: 0.85rem;
        }
        .verify-input-group input {
            width: 100%;
            padding: 0.55rem 0.85rem 0.55rem 2.2rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            color: var(--text);
            background: var(--white);
            outline: none;
            transition: all 0.2s;
        }
        .verify-input-group input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(26,115,232,0.12);
        }
        .btn-submit-verify {
            background: #1c1c2e;
            color: white;
            border: none;
            padding: 0.55rem 1.25rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            transition: all 0.2s;
        }
        .btn-submit-verify:hover {
            background: #2d2d44;
        }
        .empty-users-card {
            text-align: center;
            padding: 4.5rem 2rem;
            background: var(--bg);
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            margin: 1.5rem 0;
        }
        .empty-users-card i {
            font-size: 3.5rem;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
            display: block;
        }
        
        .toast-notify {
            padding: 0.9rem 1.4rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            animation: slideDown 0.4s ease-out;
        }
        .toast-success {
            background: #e6faf7;
            border: 1px solid #a7f3d0;
            color: #047857;
        }
        .nav-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--secondary), #56a8f5);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <div class="nav-logo">
            <div class="nav-logo-icon"><i class="fa-solid fa-database"></i></div>
            <span class="nav-logo-text">Travel<span>Scape</span> <span style="font-size:0.75rem; font-weight:600; background:var(--secondary); color:white; padding:0.15rem 0.55rem; border-radius:100px; margin-left:0.5rem; vertical-align:middle; text-transform:uppercase; letter-spacing:0.05em;">SQLite DB</span></span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <a href="{{ route('home') }}" class="back-btn" style="padding: 0.4rem 0.85rem; font-size: 0.82rem;"><i class="fa-solid fa-arrow-left"></i> TravelScape Home</a>
        </div>
    </div>
</nav>

<!-- TEST HERO HEADER -->
<header class="test-header">
    <div class="test-badge">
        <i class="fa-solid fa-database"></i> SQLite Active Database Inspector
    </div>
    <h1>Saved <span>Login Accounts</span></h1>
    <p>Live, real-time logging records queried directly from the SQLite database. Inspect raw user profiles, secure credentials, or authenticate into tester sessions.</p>
</header>

<!-- MAIN CONTENT -->
<main class="dashboard-container">
    <div class="glass-card">
        
        <!-- Flash session message -->
        @if(session('success'))
            <div class="toast-notify toast-success">
                <i class="fa-solid fa-circle-check" style="font-size: 1.15rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="console-status">
            <div class="status-indicator">
                <span class="status-dot"></span>
                <span>Database Connection: sqlite (Live Engine)</span>
            </div>
            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">
                <i class="fa-solid fa-server"></i> Table Name: <code>users</code> &bull; Total Row Count: {{ $users->count() }}
            </div>
        </div>

        <!-- USERS TESTING DASHBOARD -->
        <div style="margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-table-list" style="color: var(--secondary);"></i> Live Login Inspector
            </h2>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.25rem;">
                Inspect all columns stored inside your SQLite database schema. You can copy hashes to clipboard, test password validity using in-place verification, or immediately impersonate an account.
            </p>
        </div>

        @if($users->count() == 0)
            <!-- EMPTY STATE: No Actual Users Registered -->
            <div class="empty-users-card">
                <i class="fa-solid fa-database-exclamation"></i>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text); margin-bottom: 0.5rem;">SQLite Login Table Empty</h3>
                <p style="color: var(--text-muted); font-size: 0.88rem; max-width: 480px; margin: 0 auto 1.5rem; line-height: 1.6;">
                    There are no actual registered accounts saved in the database right now. Please create a new account using the registration portal to inspect its live SQLite record here.
                </p>
                <a href="{{ route('register') }}" class="btn-outline" style="margin: 0 auto; width: fit-content; text-decoration: none;">
                    <i class="fa-solid fa-user-plus"></i> Go to Sign Up Portal
                </a>
            </div>
        @else
            <!-- DYNAMIC SQLITE RECORDS TABLE -->
            <div class="cred-table-wrap">
                <table class="cred-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email Address</th>
                            <th>Password Hash</th>
                            <th>Email Verified</th>
                            <th>Remember Token</th>
                            <th>Created / Updated</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr id="user-row-{{ $user->id }}">
                                <td>
                                    <span class="badge-id">#{{ $user->id }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span style="font-weight: 700; color: var(--text);">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 500; color: var(--text);">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="hash-box" onclick="navigator.clipboard.writeText('{{ $user->password }}'); alert('Password hash copied to clipboard!');" title="Click to copy full hash: {{ $user->password }}">
                                        <i class="fa-regular fa-copy"></i> {{ substr($user->password, 0, 15) }}...
                                    </span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge-date">{{ $user->email_verified_at }}</span>
                                    @else
                                        <span class="badge-null">NULL</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->remember_token)
                                        <span class="badge-id" style="font-size:0.7rem;" title="{{ $user->remember_token }}">{{ substr($user->remember_token, 0, 8) }}...</span>
                                    @else
                                        <span class="badge-null">NULL</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="badge-date" style="display: flex; flex-direction: column; gap: 0.15rem;">
                                        <span>C: <strong>{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : 'N/A' }}</strong></span>
                                        <span>U: <strong>{{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i') : 'N/A' }}</strong></span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.4rem;">
                                        <!-- Test Password inline -->
                                        <button class="btn-table-action btn-verify" onclick="toggleVerifyPanel('{{ $user->id }}')" title="Verify password against this hash">
                                            <i class="fa-solid fa-key"></i> Verify
                                        </button>
                                        
                                        <!-- Quick Login -->
                                        <form action="{{ route('test.login-as', $user->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn-table-action btn-impersonate" title="Authenticate instantly into this account">
                                                <i class="fa-solid fa-user-check"></i> Login
                                            </button>
                                        </form>
                                    </div>

                                    <!-- INLINE INTERACTIVE CREDENTIAL CHECK PANEL -->
                                    <div class="inline-verify-panel" id="verify-panel-{{ $user->id }}">
                                        <div style="font-size: 0.8rem; font-weight: 700; color: var(--text); margin-bottom: 0.6rem;">
                                            Verify password against hashed key for <strong>{{ $user->email }}</strong>:
                                        </div>
                                        <form onsubmit="verifyPassword(event, '{{ $user->id }}', '{{ $user->email }}')" class="verify-form">
                                            <div class="verify-input-group">
                                                <i class="fa-solid fa-lock"></i>
                                                <input type="password" id="verify-pass-input-{{ $user->id }}" 
                                                       placeholder="Enter password..." required>
                                            </div>
                                            <button type="submit" class="btn-submit-verify" id="verify-submit-btn-{{ $user->id }}">
                                                <i class="fa-solid fa-shield-halved"></i> Verify Password
                                            </button>
                                        </form>
                                        <div id="verify-result-{{ $user->id }}" style="margin-top: 0.65rem; font-size: 0.8rem; font-weight: 700; display: none; align-items: center; gap: 0.35rem;">
                                            <!-- Dynamic result is injected here -->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <hr style="border: 0; border-top: 1px solid var(--border); margin: 3rem 0 2rem 0;">

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            <!-- Info Card 1 -->
            <div style="background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text);"><i class="fa-solid fa-shield-halved" style="color: var(--secondary)"></i> Cryptographic Hash Checking</h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.55;">
                    SQLite records store secure hashes generated using bcrypt (with a cost factor of 12). Clicking the **Verify** option runs a real-time validation via `Hash::check()`, proving that the hash matches the plaintext password perfectly without storing passwords in raw form.
                </p>
            </div>
            <!-- Info Card 2 -->
            <div style="background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text);"><i class="fa-solid fa-clipboard-check" style="color: var(--accent)"></i> Clipboard Utility</h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.55;">
                    The Password Hash column displays truncated previews of the stored passwords. Clicking any hash instantly copies the full 60-character cryptographic key string to your clipboard for quick debugging.
                </p>
            </div>
        </div>

    </div>
</main>

<!-- FOOTER -->
<footer class="footer" style="margin-top: 4rem;">
    <p>
        &copy; 2026 <span>TravelScape DevTools</span> &bull; SQLite Live Logins Inspector Panel.
    </p>
</footer>

<script>
    function toggleVerifyPanel(userId) {
        const panels = document.querySelectorAll('.inline-verify-panel');
        panels.forEach(panel => {
            if (panel.id !== `verify-panel-${userId}`) {
                panel.style.display = 'none';
            }
        });
        
        const currentPanel = document.getElementById(`verify-panel-${userId}`);
        if (currentPanel.style.display === 'block') {
            currentPanel.style.display = 'none';
        } else {
            currentPanel.style.display = 'block';
            document.getElementById(`verify-pass-input-${userId}`).focus();
        }
    }

    function verifyPassword(event, userId, email) {
        event.preventDefault();
        
        const passwordInput = document.getElementById(`verify-pass-input-${userId}`);
        const submitBtn = document.getElementById(`verify-submit-btn-${userId}`);
        const resultContainer = document.getElementById(`verify-result-${userId}`);
        
        const password = passwordInput.value;
        
        // Show spinner / loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Checking Hash...';
        
        resultContainer.style.display = 'none';
        resultContainer.innerHTML = '';
        
        fetch("{{ route('test.check-credentials') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: email, password: password })
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-shield-halved"></i> Verify Password';
            
            resultContainer.style.display = 'flex';
            if (data.success) {
                resultContainer.style.color = '#047857';
                resultContainer.innerHTML = `
                    <i class="fa-solid fa-circle-check" style="font-size: 1.05rem;"></i>
                    <span>${data.message}</span>
                `;
            } else {
                resultContainer.style.color = '#b91c1c';
                resultContainer.innerHTML = `
                    <i class="fa-solid fa-circle-xmark" style="font-size: 1.05rem;"></i>
                    <span>${data.message}</span>
                `;
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-shield-halved"></i> Verify Password';
            resultContainer.style.display = 'flex';
            resultContainer.style.color = '#b91c1c';
            resultContainer.innerHTML = `
                <i class="fa-solid fa-circle-exclamation" style="font-size: 1.05rem;"></i>
                <span>Connection error. Please try again.</span>
            `;
            console.error("Auth test error: ", error);
        });
    }
</script>

</body>
</html>
