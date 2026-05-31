<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Walkthrough & Dev Console – TravelScape</title>
    <meta name="description" content="TravelScape Interactive Walkthrough and Live SQLite Database Inspector. Access restricted.">
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

        /* ── INTERACTIVE SYSTEM DATA FLOW VISUALIZER Styles ── */
        .df-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        [data-theme="dark"] .df-card {
            background: #111b2e;
        }
        .df-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.75rem;
            background: var(--white);
            padding: 0.4rem;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }
        .df-tab-btn {
            flex: 1;
            min-width: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            border: none;
            background: transparent;
            transition: all 0.25s ease;
            font-family: inherit;
        }
        .df-tab-btn.active {
            color: var(--white);
            background: var(--secondary);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.25);
        }
        .df-tab-btn:hover:not(.active) {
            background: var(--border);
            color: var(--text);
        }
        .df-pipeline {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            position: relative;
            margin-bottom: 2rem;
        }
        .df-node {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }
        .df-node::after {
            content: '';
            position: absolute;
            right: -1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.5rem;
            height: 2px;
            background: var(--border);
            z-index: 1;
            display: none;
        }
        @media (min-width: 992px) {
            .df-node::after {
                display: block;
            }
            .df-node:last-child::after {
                display: none;
            }
        }
        .df-node-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text);
        }
        .df-node-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: white;
        }
        .df-node-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--bg);
            color: var(--text-muted);
            width: fit-content;
        }
        .df-node-content {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.45;
        }
        
        /* Node types colors */
        .icon-client { background: var(--primary); }
        .icon-route { background: var(--secondary); }
        .icon-controller { background: #8b5cf6; }
        .icon-db { background: var(--accent); }
        
        /* Interactive Highlight states */
        .df-node.highlighted {
            border-color: var(--secondary);
            box-shadow: 0 0 15px rgba(26, 115, 232, 0.25);
            transform: translateY(-2px);
        }
        .df-node.highlighted-primary {
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(255, 90, 48, 0.25);
            transform: translateY(-2px);
        }
        .df-node.highlighted-accent {
            border-color: var(--accent);
            box-shadow: 0 0 15px rgba(0, 201, 167, 0.25);
            transform: translateY(-2px);
        }
        
        .df-flow-details {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.75rem;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .df-flow-details {
                grid-template-columns: 1fr 1fr;
            }
        }
        .df-steps {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .df-step-item {
            display: flex;
            gap: 1rem;
            position: relative;
        }
        .df-step-item::after {
            content: '';
            position: absolute;
            left: 14px;
            top: 28px;
            bottom: -20px;
            width: 2px;
            background: var(--border);
            z-index: 1;
        }
        .df-step-item:last-child::after {
            display: none;
        }
        .df-step-num {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--bg);
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            z-index: 2;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }
        .df-step-item.active .df-step-num {
            background: var(--secondary);
            border-color: var(--secondary);
            color: white;
            box-shadow: 0 0 8px rgba(26, 115, 232, 0.4);
        }
        .df-step-content {
            padding-top: 0.2rem;
        }
        .df-step-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text);
            margin-bottom: 0.25rem;
        }
        .df-step-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.45;
        }
        
        .df-code-panel {
            background: #0f172a;
            border-radius: var(--radius-sm);
            padding: 1.25rem;
            border: 1px solid #1e293b;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            overflow-x: auto;
        }
        .df-code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
            font-weight: 700;
            color: #94a3b8;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 0.5rem;
        }
        .df-code-header span {
            color: var(--accent);
        }
        .df-code-body {
            font-family: monospace;
            font-size: 0.78rem;
            line-height: 1.5;
            white-space: pre;
        }
        .df-code-param {
            color: #38bdf8;
        }
        .df-code-keyword {
            color: #f472b6;
        }
        .df-code-string {
            color: #34d399;
        }
        .df-code-comment {
            color: #64748b;
            font-style: italic;
        }
        .schema-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .schema-table-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        .schema-table-header {
            background: var(--border);
            padding: 0.6rem 0.9rem;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .schema-table-rows {
            padding: 0.5rem 0.9rem;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .schema-field {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
            font-family: monospace;
            color: var(--text-muted);
        }
        .schema-field-name {
            font-weight: 600;
            color: var(--text);
        }
        .schema-field-type {
            opacity: 0.8;
            font-size: 0.65rem;
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
        <i class="fa-solid fa-compass"></i> TravelScape Platform Walkthrough
    </div>
    <h1>Developer <span>Walkthrough & Database Console</span></h1>
    <p>Interactive data flow visualizer and real-time SQLite database inspector. Trace site architecture flows, view live schemas, or authenticate instantly into testing sessions.</p>
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

        <!-- INTERACTIVE SYSTEM DATA FLOW VISUALIZER -->
        <div class="df-card">
            <div style="margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-diagram-project" style="color: var(--primary);"></i> TravelScape Web Architecture & Data Flow
                </h2>
                <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.25rem;">
                    Analyze how data propagates across different layers of the Laravel 12 application. Click a flow type to animate the pipeline path and view the database schema relationships.
                </p>
            </div>

            <!-- Tab Selectors -->
            <div class="df-tabs">
                <button class="df-tab-btn active" id="tab-btn-recommendation" onclick="selectJourney('recommendation')">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> AI Recommendation Flow
                </button>
                <button class="df-tab-btn" id="tab-btn-hotel" onclick="selectJourney('hotel')">
                    <i class="fa-solid fa-hotel"></i> Stays Booking Flow
                </button>
                <button class="df-tab-btn" id="tab-btn-flight" onclick="selectJourney('flight')">
                    <i class="fa-solid fa-plane"></i> Flight Suggest Flow
                </button>
                <button class="df-tab-btn" id="tab-btn-auth" onclick="selectJourney('auth')">
                    <i class="fa-solid fa-user-check"></i> Bypass Auth Flow
                </button>
            </div>

            <!-- 4-Node Pipeline Diagram -->
            <div class="df-pipeline">
                <!-- Node 1: Client/Browser UI -->
                <div class="df-node" id="node-ui">
                    <div class="df-node-header">
                        <div class="df-node-icon icon-client"><i class="fa-solid fa-display"></i></div>
                        <span class="node-title-span">welcome.blade.php</span>
                    </div>
                    <span class="df-node-badge">Client UI</span>
                    <div class="df-node-content">User specifies budget, travel dates, and interest checks. Submits form via POST request.</div>
                </div>

                <!-- Node 2: Web Router -->
                <div class="df-node" id="node-route">
                    <div class="df-node-header">
                        <div class="df-node-icon icon-route"><i class="fa-solid fa-route"></i></div>
                        <span class="node-title-span">routes/web.php</span>
                    </div>
                    <span class="df-node-badge">Laravel Router</span>
                    <div class="df-node-content">Intercepts request path, enforces auth state filters, and dispatches to travel controller.</div>
                </div>

                <!-- Node 3: Laravel Controller -->
                <div class="df-node" id="node-controller">
                    <div class="df-node-header">
                        <div class="df-node-icon icon-controller"><i class="fa-solid fa-gears"></i></div>
                        <span class="node-title-span">TravelController</span>
                    </div>
                    <span class="df-node-badge">App Controller</span>
                    <div class="df-node-content">Runs request validations, processes logic, binds models, and prepares view contexts.</div>
                </div>

                <!-- Node 4: Database/Model -->
                <div class="df-node" id="node-db">
                    <div class="df-node-header">
                        <div class="df-node-icon icon-db"><i class="fa-solid fa-database"></i></div>
                        <span class="node-title-span">destinations table</span>
                    </div>
                    <span class="df-node-badge">SQLite Database</span>
                    <div class="df-node-content">Eloquent executes SQL matching constraints. Hydrates models, sending collection array back.</div>
                </div>
            </div>

            <!-- Flow Details Sidebar Grid -->
            <div class="df-flow-details">
                <!-- Left: Pipeline Stepper -->
                <div>
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 1.25rem;">
                        <i class="fa-solid fa-list-ol" style="color: var(--secondary);"></i> Request Execution Pipeline
                    </h3>
                    <div class="df-steps" id="df-steps-container">
                        <!-- Dynamic Steps injected by JS -->
                    </div>
                </div>

                <!-- Right: Code Snippet Panel -->
                <div class="df-code-panel">
                    <div class="df-code-header" id="df-code-file-label">
                        Interactive Data Flow: <span>AI RECOMMENDATION JOURNEY</span>
                    </div>
                    <div class="df-code-body" id="df-code-body">
                        <!-- Dynamic Code content injected by JS -->
                    </div>
                </div>
            </div>

            <!-- Database Relations Explorer -->
            <div style="margin-top: 3rem; border-top: 1px dashed var(--border); padding-top: 2rem;">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.4rem;">
                    <i class="fa-solid fa-circle-nodes" style="color: var(--accent);"></i> SQLite Database Schema & Relations Map
                </h3>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 1.25rem;">
                    Browse table structural models in your SQLite file. TravelScape maps these models using Eloquent relations.
                </p>
                <div class="schema-grid">
                    <!-- Users -->
                    <div class="schema-table-card">
                        <div class="schema-table-header"><i class="fa-solid fa-users" style="color: var(--secondary); font-size: 0.75rem;"></i> users</div>
                        <div class="schema-table-rows">
                            <div class="schema-field"><span class="schema-field-name">id</span><span class="schema-field-type">INT (PK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">name</span><span class="schema-field-type">VARCHAR</span></div>
                            <div class="schema-field"><span class="schema-field-name">email</span><span class="schema-field-type">VARCHAR (UQ)</span></div>
                            <div class="schema-field"><span class="schema-field-name">password</span><span class="schema-field-type">HASH</span></div>
                            <div class="schema-field"><span class="schema-field-name">created_at</span><span class="schema-field-type">TIMESTAMP</span></div>
                        </div>
                    </div>
                    <!-- Bookings -->
                    <div class="schema-table-card">
                        <div class="schema-table-header"><i class="fa-solid fa-ticket" style="color: var(--primary); font-size: 0.75rem;"></i> bookings</div>
                        <div class="schema-table-rows">
                            <div class="schema-field"><span class="schema-field-name">id</span><span class="schema-field-type">INT (PK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">booking_reference</span><span class="schema-field-type">STR (UQ)</span></div>
                            <div class="schema-field"><span class="schema-field-name">destination_id</span><span class="schema-field-type">INT (FK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">hotel_id</span><span class="schema-field-type">INT (FK, NULL)</span></div>
                            <div class="schema-field"><span class="schema-field-name">customer_email</span><span class="schema-field-type">VARCHAR</span></div>
                            <div class="schema-field"><span class="schema-field-name">start_date</span><span class="schema-field-type">DATE</span></div>
                            <div class="schema-field"><span class="schema-field-name">total_price</span><span class="schema-field-type">DECIMAL</span></div>
                            <div class="schema-field"><span class="schema-field-name">status</span><span class="schema-field-type">VARCHAR</span></div>
                        </div>
                    </div>
                    <!-- Destinations -->
                    <div class="schema-table-card">
                        <div class="schema-table-header"><i class="fa-solid fa-map-location-dot" style="color: var(--accent); font-size: 0.75rem;"></i> destinations</div>
                        <div class="schema-table-rows">
                            <div class="schema-field"><span class="schema-field-name">id</span><span class="schema-field-type">INT (PK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">name</span><span class="schema-field-type">VARCHAR</span></div>
                            <div class="schema-field"><span class="schema-field-name">min_budget</span><span class="schema-field-type">DECIMAL</span></div>
                            <div class="schema-field"><span class="schema-field-name">best_months</span><span class="schema-field-type">JSON</span></div>
                            <div class="schema-field"><span class="schema-field-name">image_url</span><span class="schema-field-type">VARCHAR</span></div>
                        </div>
                    </div>
                    <!-- Hotels -->
                    <div class="schema-table-card">
                        <div class="schema-table-header"><i class="fa-solid fa-hotel" style="color: #8b5cf6; font-size: 0.75rem;"></i> hotels</div>
                        <div class="schema-table-rows">
                            <div class="schema-field"><span class="schema-field-name">id</span><span class="schema-field-type">INT (PK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">destination_id</span><span class="schema-field-type">INT (FK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">name</span><span class="schema-field-type">VARCHAR</span></div>
                            <div class="schema-field"><span class="schema-field-name">price_per_night</span><span class="schema-field-type">DECIMAL</span></div>
                            <div class="schema-field"><span class="schema-field-name">rating</span><span class="schema-field-type">DOUBLE</span></div>
                        </div>
                    </div>
                    <!-- Companions -->
                    <div class="schema-table-card">
                        <div class="schema-table-header"><i class="fa-solid fa-user-group" style="color: #ec4899; font-size: 0.75rem;"></i> companions</div>
                        <div class="schema-table-rows">
                            <div class="schema-field"><span class="schema-field-name">id</span><span class="schema-field-type">INT (PK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">user_id</span><span class="schema-field-type">INT (FK)</span></div>
                            <div class="schema-field"><span class="schema-field-name">name</span><span class="schema-field-type">VARCHAR</span></div>
                            <div class="schema-field"><span class="schema-field-name">relationship</span><span class="schema-field-type">VARCHAR</span></div>
                        </div>
                    </div>
                </div>
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

    // ── INTERACTIVE SYSTEM DATA FLOW VISUALIZER SCRIPT ──
    const journeyData = {
        recommendation: {
            nodes: [
                { id: 'node-ui', class: 'highlighted-primary', badge: 'Client UI', title: 'welcome.blade.php', text: 'User specifies budget ($2000), date bounds, and checks activities. Submits form via POST request.' },
                { id: 'node-route', class: 'highlighted', badge: 'Laravel Router', title: "Route::post('/recommend')", text: 'Routes request to TravelController@recommend, checked by auth state middleware.' },
                { id: 'node-controller', class: 'highlighted', badge: 'App Controller', title: 'TravelController@recommend', text: 'Parses months, applies min_budget SQLite Eloquent logic, runs activity inner-joins.' },
                { id: 'node-db', class: 'highlighted-accent', badge: 'SQLite DB', title: 'Destinations & Activities', text: 'Executes SQL filters, queries destinations by budget and seasonality. Returns recommendations view.' }
            ],
            steps: [
                { num: 1, title: 'Client UI Form Submission', desc: 'The client enters travel parameters ($2,000 budget, Relaxation/Adventure checks) on welcome.blade.php, posting payload parameters to the backend.' },
                { num: 2, title: 'Route Resolution & Auth Filter', desc: 'The routing engine maps POST /recommend to the controller, validating CSRF authenticity, and verifying auth status.' },
                { num: 3, title: 'Eloquent Filtering Controller Logic', desc: 'TravelController parses the start month, queries Destination model checking budget filters, and checks overlap against best_months JSON field.' },
                { num: 4, title: 'SQLite Database query & Response', desc: 'SQLite engine executes the query. Hydrates matching destinations collection, rendering recommendations.blade.php for the client.' }
            ],
            code: `// TravelController.php - AI recommendations logic
public function recommend(Request $request)
{
    $request->validate([
        'budget' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'activities' => 'array',
    ]);

    $budget = $request->budget;
    $startMonth = date('n', strtotime($request->start_date));

    // Eloquent DB logic querying SQLite
    $destinations = Destination::query()
        ->where('min_budget', '<=', $budget)
        ->whereJsonContains('best_months', (int)$startMonth)
        ->whereHas('activities', function($q) use ($request) {
            $q->whereIn('activities.id', $request->activities);
        })
        ->get();

    return view('recommendations', compact('destinations', 'budget'));
}`
        },
        hotel: {
            nodes: [
                { id: 'node-ui', class: 'highlighted-primary', badge: 'Client UI', title: 'hotels/show.blade.php', text: 'User reviews hotel/airbnb details, enters travelers count, and clicks "Book Stay".' },
                { id: 'node-route', class: 'highlighted', badge: 'Laravel Router', title: "Route::post('/hotels/{hotel}/book')", text: 'Enforces auth check. Directs post parameters to HotelController@book.' },
                { id: 'node-controller', class: 'highlighted', badge: 'App Controller', title: 'HotelController@book', text: 'Computes total price, instantiates new Booking Eloquent instance, triggers boarding pass email.' },
                { id: 'node-db', class: 'highlighted-accent', badge: 'SQLite DB', title: 'Bookings Database', text: 'Inserts row in bookings table (hotel_id set, status="confirmed"). Generates reference.' }
            ],
            steps: [
                { num: 1, title: 'Submit Booking Form', desc: 'The authenticated user triggers a booking process on the Hotel Detail page, sending guest details and check-in date boundaries.' },
                { num: 2, title: 'Auth Intercept & Routing', desc: 'Laravel captures POST /hotels/{hotel}/book, ensuring auth middleware blocks guests, redirecting unauthorized traffic.' },
                { num: 3, title: 'Invoice & DB Entry Creation', desc: 'HotelController loads the Hotel model, calculates invoice prices ($PricePerNight * $Nights), and instantiates a new Booking record.' },
                { num: 4, title: 'Database Insert & Mail Queue', desc: 'SQLite writes the booking row. A custom UUID reference is generated. Dispatches BoardingPassMail. Client redirects to confirmation view.' }
            ],
            code: `// HotelController.php - Hotel Stays Booking Logic
public function book(Request $request, Hotel $hotel)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'travelers' => 'required|integer|min:1',
    ]);

    $days = max(1, (strtotime($request->end_date) - strtotime($request->start_date)) / 86400);
    $totalPrice = $hotel->price_per_night * $days * $request->travelers;

    // Database record instantiation
    $booking = Booking::create([
        'destination_id' => $hotel->destination_id,
        'hotel_id' => $hotel->id,
        'customer_name' => auth()->user()->name,
        'customer_email' => auth()->user()->email,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'num_travelers' => $request->travelers,
        'total_price' => $totalPrice,
        'status' => 'confirmed',
    ]);

    // Send boarding pass / confirmation email
    Mail::to($booking->customer_email)->send(new BoardingPassMail($booking));

    return redirect()->route('bookings.confirmation', $booking->booking_reference);
}`
        },
        flight: {
            nodes: [
                { id: 'node-ui', class: 'highlighted-primary', badge: 'Client UI', title: 'flights/results.blade.php', text: 'Client executes flight search (source, destination, date, travelers). Offers render with predicted pricing.' },
                { id: 'node-route', class: 'highlighted', badge: 'Laravel Router', title: "Route::post('/flights/search')", text: 'Captures search input payload, enforces auth middleware, redirects to FlightController@search.' },
                { id: 'node-controller', class: 'highlighted', badge: 'App Controller', title: 'FlightController@search', text: 'Computes days to departure, issues HTTP requests to predicting model, handles timeouts, applies fallbacks.' },
                { id: 'node-db', class: 'highlighted-accent', badge: 'SQLite DB & API', title: 'Prediction API & Destinations', text: 'Queries destinations table, makes dynamic HTTP request to Predictor API. Renders ticket cards.' }
            ],
            steps: [
                { num: 1, title: 'Flight Search Input', desc: 'The traveler submits departure city and destination. The system maps airport suggestions dynamically using disk caches.' },
                { num: 2, title: 'Route Resolution', desc: 'Laravel captures POST /flights/search, validating authenticity tokens and ensuring active session variables exist.' },
                { num: 3, title: 'HTTP Price Prediction API POST Payload', desc: 'FlightController dispatches a REST POST payload to herokuapp /predict with JSON:<br><pre style="background:#1e293b; padding:0.5rem; border-radius:4px; margin-top:0.3rem; font-family:monospace; color:#38bdf8; font-size:0.75rem;">{\n  "airline": "Delta Air Lines",\n  "source": "New York",\n  "destination": "Paris",\n  "days_left": 14,\n  "class": "Economy",\n  "stops": "1 Stop (BOS)"\n}</pre>' },
                { num: 4, title: 'API Response Parser & Dynamic Render', desc: 'Receives price prediction response JSON. If offline, it triggers a local regression pricing curve algorithm:<br><pre style="background:#1e293b; padding:0.5rem; border-radius:4px; margin-top:0.3rem; font-family:monospace; color:#34d399; font-size:0.75rem;">{\n  "success": true,\n  "predicted_price": 582,\n  "days_left": 14,\n  "algorithm": "RandomForest"\n}</pre>' }
            ],
            code: `// FlightController.php - Dynamic Flight Pricing API Integration
public function search(Request $request)
{
    $request->validate([
        'departure' => 'required|string',
        'destination' => 'required|string',
        'departure_date' => 'required|date',
    ]);

    $daysToDeparture = max(1, ceil((strtotime($request->departure_date) - time()) / 86400));
    $flights = [ ... ]; // 8 distinct dynamic offers

    foreach ($flights as &$flight) {
        $apiPrice = null;
        
        // 1. Dynamic REST API POST request to predictive model
        try {
            $response = Http::timeout(1.2)->post('https://flight-price-prediction-api.herokuapp.com/predict', [
                'airline' => $flight['airline'],
                'source' => $request->departure,
                'destination' => $request->destination,
                'days_left' => $daysToDeparture,
                'class' => $flight['class'],
                'stops' => $flight['stops'],
            ]);
            
            if ($response->successful()) {
                $apiPrice = $response->json()['predicted_price'];
            }
        } catch (\\Exception $e) {
            // Local fallback simulation triggers if API offline
        }

        $flight['price'] = $apiPrice ?: $this->calculateFallbackPrice($flight, $daysToDeparture);
    }
    return view('flights.results', compact('flights'));
}`
        },
        auth: {
            nodes: [
                { id: 'node-ui', class: 'highlighted-primary', badge: 'Client UI', title: 'test.blade.php (Inspector)', text: 'Tester inspects SQLite row entries, finds target account, clicks "Login" button.' },
                { id: 'node-route', class: 'highlighted', badge: 'Laravel Router', title: "Route::post('/test/login-as/{id}')", text: 'Intercepts developer override login requests, bypassing normal forms.' },
                { id: 'node-controller', class: 'highlighted', badge: 'App Router Closure', title: 'Test Login Route Callback', text: 'Pulls target User model instance, triggers session authenticate and regenerates session cookies.' },
                { id: 'node-db', class: 'highlighted-accent', badge: 'SQLite DB', title: 'Users table query', text: 'Runs SQLite search: SELECT * FROM users WHERE id = ? -> Authenticates session, redirects home.' }
            ],
            steps: [
                { num: 1, title: 'Developer Impersonation request', desc: 'Clicking login on the live inspector triggers POST /test/login-as/{user_id}, calling the developer closure callback.' },
                { num: 2, title: 'Route implicit model binding', desc: 'Laravel resolves the user ID implicit binding, executing User::findOrFail($id) automatically against SQLite.' },
                { num: 3, title: 'Authentication bypass', desc: 'Calls Auth::login($user) to register the user session immediately, followed by session cookie regeneration.' },
                { num: 4, title: 'Redirect & Flash alerts', desc: 'Flashes successful authentication alert into session state, redirecting traveler homepage with success banner.' }
            ],
            code: `// routes/web.php - Developer impersonation bypass route
Route::post('/test/login-as/{user}', function (User $user) {
    // Authenticate instantly bypass
    Auth::login($user);
    
    // Regenerate session cookies to prevent session fixation attacks
    request()->session()->regenerate();
    
    // Redirect with success flash banner
    return redirect()->route('home')
        ->with('success', "Logged in instantly as {$user->name}!");
})->name('test.login-as');`
        }
    };

    function selectJourney(journeyId) {
        // Remove active class from buttons
        document.querySelectorAll('.df-tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        // Add active to selected button
        document.getElementById('tab-btn-' + journeyId).classList.add('active');
        
        const data = journeyData[journeyId];
        
        // Render Nodes
        data.nodes.forEach(node => {
            const el = document.getElementById(node.id);
            if (el) {
                // Remove previous highlights
                el.className = 'df-node';
                // Add new highlights class
                el.classList.add(node.class);
                // Update contents
                el.querySelector('.df-node-badge').innerText = node.badge;
                el.querySelector('.node-title-span').innerText = node.title;
                el.querySelector('.df-node-content').innerText = node.text;
            }
        });
        
        // Render Steps
        const stepsContainer = document.getElementById('df-steps-container');
        stepsContainer.innerHTML = '';
        data.steps.forEach(step => {
            const html = 
                '<div class="df-step-item active">' +
                    '<div class="df-step-num">' + step.num + '</div>' +
                    '<div class="df-step-content">' +
                        '<div class="df-step-title">' + step.title + '</div>' +
                        '<div class="df-step-desc">' + step.desc + '</div>' +
                    '</div>' +
                '</div>';
            stepsContainer.innerHTML += html;
        });
        
        // Render Code Panel
        const codeBody = document.getElementById('df-code-body');
        // Escape HTML
        const escapedCode = data.code
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
        
        codeBody.innerHTML = escapedCode;
        
        // Code Syntax Highlighting (regex helpers)
        let highlighted = codeBody.innerHTML;
        
        // Keywords
        highlighted = highlighted.replace(/\b(public|function|return|use|new|class|extends|protected|private|static)\b/g, '<span class="df-code-keyword">$1</span>');
        // PHP variables
        highlighted = highlighted.replace(/(\$[a-zA-Z0-9_]+)/g, '<span class="df-code-param">$1</span>');
        // Comments
        highlighted = highlighted.replace(/(\/{2}.*)/g, '<span class="df-code-comment">$1</span>');
        
        codeBody.innerHTML = highlighted;
        
        // Update active label in code header
        document.getElementById('df-code-file-label').innerHTML = 'Interactive Data Flow: <span>' + journeyId.toUpperCase() + ' JOURNEY</span>';
    }

    // Initialize defaults on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        selectJourney('recommendation');
    });
</script>

</body>
</html>
