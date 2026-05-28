<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile & Companions – TravelScape</title>
    <meta name="description" content="Manage your personal travel profile, set preferences, and add family or friends for quick autofill bookings.">
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
        .profile-header {
            background: linear-gradient(135deg, #FF5A30 0%, #1A73E8 100%);
            padding: 4.5rem 1.5rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid var(--primary);
        }
        .profile-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 60%);
            pointer-events: none;
        }
        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #FFD166;
            padding: 0.4rem 1.25rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .profile-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }
        .profile-header p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .dashboard-container {
            max-width: 1000px;
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
        .profile-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2.25rem;
            border-bottom: 2px solid var(--border);
            padding-bottom: 0;
        }
        .profile-tab {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.5rem;
            border-radius: var(--radius-sm) var(--radius-sm) 0 0;
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            border: none;
            background: none;
            position: relative;
            bottom: -2px;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            font-family: inherit;
        }
        .profile-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            background: var(--primary-light);
        }
        .profile-tab:hover:not(.active) {
            color: var(--text);
            background: var(--bg);
        }
        
        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }
        .tab-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pref-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
            margin-top: 1.25rem;
            background: var(--bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.5rem;
        }
        @media (max-width: 768px) {
            .pref-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Companion Cards Layout */
        .companions-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 1.5rem;
        }
        .companion-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem 1.5rem;
            position: relative;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
        }
        .companion-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: var(--shadow);
            background: var(--white);
        }
        .comp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .comp-name-wrap {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }
        .comp-avatar {
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
        .comp-name {
            font-weight: 700;
            color: var(--text);
            font-size: 0.98rem;
        }
        .comp-relation-badge {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .comp-details {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }
        .comp-details span {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .comp-details i {
            color: var(--secondary);
            width: 14px;
            text-align: center;
        }
        .btn-delete-comp {
            background: none;
            border: none;
            color: #b91c1c;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s;
            outline: none;
            width: fit-content;
        }
        .btn-delete-comp:hover {
            background: #fef2f2;
            color: #7f1d1d;
        }
        
        .empty-companions {
            text-align: center;
            padding: 3.5rem 2rem;
            background: var(--bg);
            border: 2px dashed var(--border);
            border-radius: var(--radius);
        }
        .empty-companions i {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
            display: block;
        }
        .empty-companions h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.4rem;
        }
        .empty-companions p {
            color: var(--text-muted);
            font-size: 0.85rem;
            max-width: 380px;
            margin: 0 auto 1.5rem;
            line-height: 1.5;
        }

        /* Modal popup dialog */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            animation: fadeInOverlay 0.2s ease-out;
        }
        .modal-box {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
            animation: zoomIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes fadeInOverlay {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes zoomIn {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .modal-header {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-header h3 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text);
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.2rem;
            transition: color 0.2s;
        }
        .modal-close:hover {
            color: var(--primary);
        }
        .modal-body {
            padding: 1.75rem;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="nav-logo-icon"><i class="fa-solid fa-compass"></i></div>
            <span class="nav-logo-text">Travel<span>Scape</span></span>
        </a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}#how-it-works">How It Works</a></li>
            <li><a href="{{ route('home') }}">Find Destinations</a></li>
            <li><a href="{{ route('hotels.index') }}">Hotels & Airbnbs</a></li>
            <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            @auth
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; padding: 0.5rem 0.9rem; cursor: pointer; border-radius: var(--radius-sm); transition: all 0.2s; font-family: inherit; display: inline-flex; align-items: center; gap: 0.35rem;" onmouseover="this.style.color='var(--primary)'; this.style.background='var(--primary-light)';" onmouseout="this.style.color='var(--text-muted)'; this.style.background='none';">
                            <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                        </button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<!-- PROFILE HEADER -->
<header class="profile-header">
    <div class="profile-badge">
        <i class="fa-solid fa-circle-user"></i> {{ $user->email }}
    </div>
    <h1>Hello, <span>{{ $user->name }}</span></h1>
    <p>Manage your passport details, preferences, and companions to auto-fill bookings instantly all across TravelScape.</p>
</header>

<!-- MAIN CONTENT -->
<main class="dashboard-container">
    <div class="glass-card">
        
        <!-- Alerts success -->
        @if(session('success'))
            <div style="background:#e6faf7; border:1px solid #a7f3d0; border-radius:10px; padding:1rem 1.5rem; color:#047857; font-size:0.9rem; display:flex; align-items:center; gap:0.6rem; box-shadow: var(--shadow); margin-bottom: 2rem;" class="fade-in">
                <i class="fa-solid fa-circle-check" style="font-size:1.15rem"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; border-radius:10px; padding:1rem 1.5rem; color:#b91c1c; font-size:0.9rem; display:flex; flex-direction:column; gap:0.3rem; box-shadow: var(--shadow); margin-bottom: 2rem;" class="fade-in">
                @foreach ($errors->all() as $error)
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <i class="fa-solid fa-circle-xmark" style="font-size:1.05rem"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Tab switches -->
        <div class="profile-tabs">
            <button class="profile-tab active" onclick="switchProfileTab('my-profile', this)">
                <i class="fa-solid fa-user-shield"></i> Profile &amp; Preferences
            </button>
            <button class="profile-tab" onclick="switchProfileTab('my-companions', this)">
                <i class="fa-solid fa-user-group"></i> Family &amp; Friends ({{ $companions->count() }})
            </button>
        </div>

        <!-- TAB 1: PROFILE FORM -->
        <div class="tab-content active" id="my-profile">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin-bottom: 0.5rem;"><i class="fa-solid fa-user-pen" style="color: var(--primary); margin-right: 0.35rem;"></i> Personal Boarding Information</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem;">These personal details are securely held and will auto-populate as "Lead Guest" or "Primary Passenger" on booking checkouts.</p>

                <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name">Full Name (As in Passport)</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-signature"></i>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>
                    
                    <!-- Email address (readonly for system account integrity) -->
                    <div class="form-group">
                        <label for="email">Primary Email Address</label>
                        <div class="input-icon-wrap" style="opacity:0.75;">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="email" value="{{ $user->email }}" readonly style="cursor:not-allowed; background:var(--border);">
                        </div>
                        <small class="input-hint">Email address cannot be changed</small>
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Contact Phone Number</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +1 (555) 123-4567">
                        </div>
                    </div>

                    <!-- Passport Number -->
                    <div class="form-group">
                        <label for="passport_number">Passport Number</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-id-card"></i>
                            <input type="text" id="passport_number" name="passport_number" value="{{ old('passport_number', $user->passport_number) }}" placeholder="e.g. A98765432">
                        </div>
                        <small class="input-hint">Required for international flight bookings</small>
                    </div>

                    <!-- Date of birth -->
                    <div class="form-group">
                        <label for="birth_date">Date of Birth</label>
                        <div class="input-icon-wrap">
                            <i class="fa-regular fa-calendar"></i>
                            <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
                        </div>
                        <small class="input-hint">Used for checking passenger age groups</small>
                    </div>
                </div>

                <hr style="border:0; border-top: 1px solid var(--border); margin: 2rem 0;">

                <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text); margin-bottom: 0.5rem;"><i class="fa-solid fa-heart" style="color: var(--primary); margin-right: 0.35rem;"></i> Travel Preferences</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Set your standard cabin class and lodging configurations to automatically filter and recommend matching plans.</p>

                @php
                    $pref = $user->preferences ?? [];
                    $prefClass = $pref['preferred_class'] ?? 'Economy';
                    $prefDiet = $pref['preferred_diet'] ?? '';
                    $prefBed = $pref['preferred_bed'] ?? '';
                    $prefAirport = $pref['preferred_airport'] ?? '';
                @endphp

                <div class="pref-grid">
                    <!-- Class Selection -->
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Preferred Cabin Class</label>
                        <div style="display:flex; gap:1.25rem; flex-wrap:wrap; margin-top:0.35rem;">
                            @foreach(['Economy', 'Premium Economy', 'Business', 'First'] as $c)
                                <label style="display:inline-flex; align-items:center; gap:0.4rem; font-size:0.9rem; font-weight:550; cursor:pointer;">
                                    <input type="radio" name="preferred_class" value="{{ $c }}" {{ $prefClass == $c ? 'checked' : '' }} style="accent-color:var(--primary); width:16px; height:16px;">
                                    {{ $c }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dietary preferences -->
                    <div class="form-group">
                        <label for="preferred_diet">Dietary Requirements</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-carrot"></i>
                            <select id="preferred_diet" name="preferred_diet" style="width: 100%; padding: 0.75rem 0.85rem 0.75rem 2.4rem; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; color: var(--text); background: var(--white); outline: none;">
                                <option value="">No special diet</option>
                                <option value="Vegetarian" {{ $prefDiet == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                <option value="Vegan" {{ $prefDiet == 'Vegan' ? 'selected' : '' }}>Vegan</option>
                                <option value="Halal" {{ $prefDiet == 'Halal' ? 'selected' : '' }}>Halal</option>
                                <option value="Kosher" {{ $prefDiet == 'Kosher' ? 'selected' : '' }}>Kosher</option>
                                <option value="Gluten-Free" {{ $prefDiet == 'Gluten-Free' ? 'selected' : '' }}>Gluten-Free</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bed preference -->
                    <div class="form-group">
                        <label for="preferred_bed">Preferred Hotel Bed Type</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-bed"></i>
                            <select id="preferred_bed" name="preferred_bed" style="width: 100%; padding: 0.75rem 0.85rem 0.75rem 2.4rem; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; color: var(--text); background: var(--white); outline: none;">
                                <option value="">No preference</option>
                                <option value="Single Bed" {{ $prefBed == 'Single Bed' ? 'selected' : '' }}>Single Bed</option>
                                <option value="Double Bed" {{ $prefBed == 'Double Bed' ? 'selected' : '' }}>Double Bed</option>
                                <option value="King Bed" {{ $prefBed == 'King Bed' ? 'selected' : '' }}>King Bed / Suite</option>
                            </select>
                        </div>
                    </div>

                    <!-- Preferred Airport -->
                    <div class="form-group" style="grid-column: span 2; margin-top: 0.5rem;">
                        <label for="preferred_airport">Preferred Departure Airport</label>
                        <div class="input-icon-wrap" style="position: relative;">
                            <i class="fa-solid fa-plane-departure" style="position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.95rem; pointer-events: none;"></i>
                            <input type="text" id="preferred_airport" name="preferred_airport" placeholder="e.g. New York (JFK)" list="airports-list" value="{{ $prefAirport }}" style="width: 100%; padding: 0.75rem 0.85rem 0.75rem 2.4rem; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; color: var(--text); background: var(--white); outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        </div>
                        <small style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.25rem; display: block;">Used to automatically pre-fill your departure airport in search forms all around TravelScape.</small>
                    </div>
                </div>

                <datalist id="airports-list">
                    <option value="New York (JFK)"></option>
                    <option value="Paris Charles de Gaulle (CDG)"></option>
                    <option value="London Heathrow (LHR)"></option>
                    <option value="Bali Ngurah Rai (DPS)"></option>
                    <option value="Tokyo Narita (NRT)"></option>
                    <option value="Zurich Airport (ZRH)"></option>
                    <option value="Osaka/Kyoto Kansai (KIX)"></option>
                    <option value="Cape Town Airport (CPT)"></option>
                </datalist>

                <button type="submit" class="btn-search" style="margin-top: 2rem; width: fit-content; padding: 0.75rem 2.25rem; border-radius: 100px;">
                    <i class="fa-solid fa-floppy-disk"></i> Save Profile Details
                </button>
            </form>
        </div>

        <!-- TAB 2: COMPANIONS -->
        <div class="tab-content" id="my-companions">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text);"><i class="fa-solid fa-users" style="color: var(--secondary); margin-right: 0.35rem;"></i> Companions, Family &amp; Friends</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top:0.2rem;">Add family members or frequent travel buddies to instantly auto-fill multi-passenger checkouts.</p>
                </div>
                <button class="btn-search" onclick="openCompanionModal()" style="margin-top:0; padding:0.55rem 1.25rem; font-size:0.85rem; width:fit-content; border-radius:100px; background:var(--secondary);">
                    <i class="fa-solid fa-user-plus"></i> Add Family / Friend
                </button>
            </div>

            @if($companions->count() == 0)
                <div class="empty-companions">
                    <i class="fa-solid fa-people-arrows"></i>
                    <h3>No Companions Registered</h3>
                    <p>You haven't added any family or friends yet. Click the button to add companions, allowing you to instantly secure tickets for them with one click.</p>
                    <button class="btn-outline" onclick="openCompanionModal()">
                        <i class="fa-solid fa-user-plus"></i> Add Your First Companion
                    </button>
                </div>
            @else
                <div class="companions-list">
                    @foreach($companions as $comp)
                        <div class="companion-card">
                            <div>
                                <div class="comp-header">
                                    <div class="comp-name-wrap">
                                        <div class="comp-avatar">
                                            {{ strtoupper(substr($comp->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="comp-name">{{ $comp->name }}</div>
                                        </div>
                                    </div>
                                    <span class="comp-relation-badge">{{ $comp->relationship }}</span>
                                </div>
                                <div class="comp-details">
                                    @if($comp->email)
                                        <span><i class="fa-solid fa-envelope"></i> {{ $comp->email }}</span>
                                    @endif
                                    @if($comp->passport_number)
                                        <span><i class="fa-solid fa-id-card"></i> Passport: <strong>{{ $comp->passport_number }}</strong></span>
                                    @else
                                        <span><i class="fa-solid fa-id-card"></i> Passport: <em class="badge-null">Not set</em></span>
                                    @endif
                                    @if($comp->birth_date)
                                        <span><i class="fa-solid fa-calendar"></i> Born: <strong>{{ date('d M, Y', strtotime($comp->birth_date)) }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Delete form -->
                            <form action="{{ route('profile.companions.destroy', $comp->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $comp->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-comp">
                                    <i class="fa-regular fa-trash-can"></i> Delete Companion
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</main>

<!-- ADD COMPANION DIALOG MODAL -->
<div class="modal-overlay" id="compModal" onclick="closeCompanionModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-plus" style="color:var(--secondary);"></i> Add Family / Friend</h3>
            <button class="modal-close" onclick="closeCompanionModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('profile.companions.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-grid" style="grid-template-columns: 1fr; gap: 1rem;">
                    <!-- Companion Name -->
                    <div class="form-group">
                        <label for="companion_name">Full Name (As in Passport)</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-signature"></i>
                            <input type="text" id="companion_name" name="companion_name" placeholder="e.g. Johnathan Smith" required>
                        </div>
                    </div>

                    <!-- Relationship -->
                    <div class="form-group">
                        <label for="relationship">Relationship</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-heart"></i>
                            <select id="relationship" name="relationship" style="width: 100%; padding: 0.75rem 0.85rem 0.75rem 2.4rem; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; color: var(--text); background: var(--bg); outline: none;">
                                <option value="Spouse">Spouse / Partner</option>
                                <option value="Child">Child</option>
                                <option value="Parent">Parent</option>
                                <option value="Sibling">Sibling</option>
                                <option value="Friend">Friend</option>
                                <option value="Colleague">Colleague</option>
                            </select>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="companion_email">Email Address (Optional)</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="companion_email" name="companion_email" placeholder="e.g. john@example.com">
                        </div>
                    </div>

                    <!-- Passport Number -->
                    <div class="form-group">
                        <label for="companion_passport">Passport Number (Optional)</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-id-card"></i>
                            <input type="text" id="companion_passport" name="companion_passport" placeholder="e.g. A22334455">
                        </div>
                    </div>

                    <!-- DOB -->
                    <div class="form-group">
                        <label for="companion_dob">Date of Birth (Optional)</label>
                        <div class="input-icon-wrap">
                            <i class="fa-regular fa-calendar"></i>
                            <input type="date" id="companion_dob" name="companion_dob">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-search" style="margin-top: 1.5rem; background: var(--secondary);">
                    <i class="fa-solid fa-user-check"></i> Add Companion Profile
                </button>
            </div>
        </form>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <p>
        &copy; 2026 <span>TravelScape Account Management Portal</span> &bull; All rights reserved.
    </p>
</footer>

<script>
    function switchProfileTab(tabId, btn) {
        document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
    }

    function openCompanionModal() {
        document.getElementById('compModal').style.display = 'flex';
        document.getElementById('companion_name').focus();
    }

    function closeCompanionModal(event) {
        document.getElementById('compModal').style.display = 'none';
    }

    // Autocomplete dynamically from API instead of hardcoding
    const prefAirportInput = document.getElementById('preferred_airport');
    if (prefAirportInput) {
        prefAirportInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length < 2) return;

            fetch(`/airports/suggest?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    const datalist = document.getElementById('airports-list');
                    if (datalist) {
                        datalist.innerHTML = ''; // Clear old static suggestions
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item;
                            datalist.appendChild(opt);
                        });
                    }
                })
                .catch(err => console.error("Error loading dynamic airport suggestions: ", err));
        });
    }
</script>

</body>
</html>
