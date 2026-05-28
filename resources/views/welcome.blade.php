<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelScape – Personalized Destination Finder</title>
    <meta name="description" content="Find your perfect destination based on your budget, travel dates, and preferred activities. AI-powered personalized travel recommendations.">
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();

        function handleImgError(img) {
            img.onerror = null;
            const travels = [
                'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=800&q=80'
            ];
            img.src = travels[Math.floor(Math.random() * travels.length)];
        }

        function handleHotelImgError(img) {
            img.onerror = null;
            const hotels = [
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=800&q=80'
            ];
            img.src = hotels[Math.floor(Math.random() * hotels.length)];
        }

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
        .sponsored-banner-section {
            width: 100%;
            background: linear-gradient(180deg, rgba(26,115,232,0.02) 0%, rgba(26,115,232,0.06) 100%);
            border-top: 1px solid rgba(26,115,232,0.08);
            border-bottom: 1px solid rgba(26,115,232,0.08);
            padding: 3.5rem 0 4rem 0;
            margin: 3.5rem 0 1rem 0;
            box-sizing: border-box;
        }
        .sponsored-inner {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            padding: 0 1.5rem;
            box-sizing: border-box;
        }
        @media (min-width: 576px) {
            .sponsored-inner {
                padding: 0 2.5rem;
            }
        }
        @media (min-width: 992px) {
            .sponsored-inner {
                padding: 0 4.5rem;
            }
        }
        @media (min-width: 1400px) {
            .sponsored-inner {
                padding: 0 6rem;
        }
        
        /* Hero Slideshow & Ken Burns Zoom Effect */
        .hero {
            background: none !important;
        }
        .hero-slides {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }
        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        .hero-slide.active {
            opacity: 1;
            z-index: 1;
        }
        .hero-overlay {
            z-index: 2 !important;
        }
        .hero-content {
            z-index: 3 !important;
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
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#search">Find Destinations</a></li>
            <li><a href="{{ route('hotels.index') }}">Hotels & Airbnbs</a></li>
            <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            @auth
                <li><a href="{{ route('profile.index') }}"><i class="fa-solid fa-circle-user" style="color: var(--primary);"></i> {{ auth()->user()->name }}</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: var(--text-muted); font-size: 0.9rem; font-weight: 500; padding: 0.5rem 0.9rem; cursor: pointer; border-radius: var(--radius-sm); transition: all 0.2s; font-family: inherit; display: inline-flex; align-items: center; gap: 0.35rem;" onmouseover="this.style.color='var(--primary)'; this.style.background='var(--primary-light)';" onmouseout="this.style.color='var(--text-muted)'; this.style.background='none';">
                            <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="nav-cta"><i class="fa-solid fa-user"></i> Sign In</a></li>
            @endauth
        </ul>
    </div>
</nav>

@if(session('success'))
    <div class="page-content" style="padding-top: 1.5rem; padding-bottom: 0; max-width: 1200px; margin: 0 auto;">
        <div style="background:#e6faf7; border:1px solid #a7f3d0; border-radius:10px; padding:1rem 1.5rem; color:#047857; font-size:0.9rem; display:flex; align-items:center; gap:0.6rem; box-shadow: var(--shadow);" class="fade-in">
            <i class="fa-solid fa-circle-check" style="font-size:1.1rem"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- HERO -->
<section class="hero">
    <!-- Background Slideshow -->
    <div class="hero-slides">
        <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80');"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1600&q=80');"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80');"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1600&q=80');"></div>
        <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1600&q=80');"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <i class="fa-solid fa-wand-magic-sparkles"></i>&nbsp; Personalized just for you
        </div>
        <h1>Your <span>perfect trip</span><br>starts with your budget</h1>
        <p>Tell us your budget, dates & interests — we'll find the ideal destination for you</p>
        <div class="hero-stats">
            <div class="hero-stat">
                <strong>500+</strong>
                <span>Destinations</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <strong>50K+</strong>
                <span>Happy Travelers</span>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <strong>100%</strong>
                <span>Personalized</span>
            </div>
        </div>
    </div>
</section>

<!-- SEARCH CARD -->
<div class="search-card-wrap" id="search">
    <div class="search-card fade-in">

        <!-- Search Tabs -->
        <div class="search-tabs">
            <button class="search-tab active" onclick="switchTab('dest-finder', this)">
                <i class="fa-solid fa-wand-magic-sparkles"></i> AI Destination Finder
            </button>
            <button class="search-tab" onclick="switchTab('flight-search', this)">
                <i class="fa-solid fa-plane"></i> Flight Search
            </button>
            <button class="search-tab" onclick="switchTab('hotel-search', this)">
                <i class="fa-solid fa-hotel"></i> Stays Search
            </button>
        </div>

        <!-- AI Destination Finder Form -->
        <form action="{{ route('recommend') }}" method="POST" id="searchForm">
            @csrf
            <!-- Steps indicator -->
            <div class="steps-row" style="margin-top: 1rem;">
                <div class="step active">
                    <div class="step-icon"><i class="fa-solid fa-wallet"></i></div>
                    <span>Set Budget</span>
                </div>
                <div class="step-line"></div>
                <div class="step active">
                    <div class="step-icon"><i class="fa-regular fa-calendar"></i></div>
                    <span>Pick Dates</span>
                </div>
                <div class="step-line"></div>
                <div class="step active">
                    <div class="step-icon"><i class="fa-solid fa-list-check"></i></div>
                    <span>Your Interests</span>
                </div>
                <div class="step-line"></div>
                <div class="step">
                    <div class="step-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                    <span>Get Matches</span>
                </div>
            </div>

            <div class="form-grid">

                <!-- Budget -->
                <div class="form-group">
                    <label for="budget">Total Budget (USD $)</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <input type="number" id="budget" name="budget"
                               placeholder="e.g. 2000" required min="100"
                               value="{{ old('budget') }}">
                    </div>
                    <small class="input-hint">All-inclusive: flights, hotel & activities</small>
                </div>

                <!-- Departure -->
                <div class="form-group">
                    <label for="start_date">Departure Date</label>
                    <div class="input-icon-wrap">
                        <i class="fa-regular fa-calendar-check"></i>
                        <input type="date" id="start_date" name="start_date"
                               required value="{{ old('start_date') }}">
                    </div>
                    <small class="input-hint">We match destinations by season</small>
                </div>

                <!-- Return -->
                <div class="form-group">
                    <label for="end_date">Return Date</label>
                    <div class="input-icon-wrap">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        <input type="date" id="end_date" name="end_date"
                               required value="{{ old('end_date') }}">
                    </div>
                    <small class="input-hint">Helps us calculate trip duration</small>
                </div>

                <!-- Activities -->
                <div class="form-group full">
                    <label>What kind of traveler are you?</label>
                    <p style="font-size:0.82rem;color:#6b7280;margin-bottom:0.6rem;margin-top:-0.1rem;">
                        Select all that apply — the more you pick, the better we match!
                    </p>
                    <div class="activity-chips">
                        @foreach($activities as $activity)
                            <label class="activity-chip">
                                <input type="checkbox" name="activities[]" value="{{ $activity->id }}">
                                <span>{{ $activity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group full">
                    <button type="submit" class="btn-search" id="searchBtn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Find My Perfect Destination
                    </button>
                </div>
            </div>
        </form>

        <!-- Flight Search Form -->
        <form action="{{ route('flights.search') }}" method="POST" id="flightSearchForm" style="display: none;">
            @csrf
            
            <!-- Auto-suggest Datalist -->
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

            <div class="form-grid" style="margin-top: 1.5rem;">
                <!-- Departure -->
                <div class="form-group">
                    <label for="departure">Departure City / Airport</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-plane-departure"></i>
                        <input type="text" id="departure" name="departure" placeholder="e.g. New York (JFK)" list="airports-list" required value="{{ old('departure', auth()->check() && isset(auth()->user()->preferences['preferred_airport']) ? auth()->user()->preferences['preferred_airport'] : '') }}">
                    </div>
                    <small class="input-hint">City name or 3-letter code</small>
                </div>

                <!-- Destination -->
                <div class="form-group">
                    <label for="destination">Destination City / Airport</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-plane-arrival"></i>
                        <input type="text" id="destination" name="destination" placeholder="e.g. Paris (CDG)" list="airports-list" required value="{{ old('destination') }}">
                    </div>
                    <small class="input-hint">Where are you flying to?</small>
                </div>

                <!-- Departure Date -->
                <div class="form-group half">
                    <label for="flight_start_date">Departure Date</label>
                    <div class="input-icon-wrap">
                        <i class="fa-regular fa-calendar-check"></i>
                        <input type="date" id="flight_start_date" name="departure_date" required>
                    </div>
                </div>

                <!-- Return Date -->
                <div class="form-group half">
                    <label for="flight_end_date">Return Date (Optional)</label>
                    <div class="input-icon-wrap">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        <input type="date" id="flight_end_date" name="return_date">
                    </div>
                </div>

                <!-- Travelers -->
                <div class="form-group half">
                    <label for="flight_travelers">Travelers</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-users"></i>
                        <input type="number" id="flight_travelers" name="travelers" min="1" max="10" value="1" required>
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group full" style="grid-column: span 3;">
                    <button type="submit" class="btn-search" id="flightSearchBtn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Search Matching Flight Tickets
                    </button>
                </div>
            </div>
        </form>

        <!-- Accommodations Search Form -->
        <form action="{{ route('hotels.index') }}" method="GET" id="hotelSearchForm" style="display: none;">
            <div class="form-grid" style="margin-top: 1.5rem;">
                <!-- Location -->
                <div class="form-group" style="grid-column: span 2;">
                    <label for="hotel_location">Where are you staying?</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" id="hotel_location" name="location" placeholder="e.g. Bali, Paris, Tokyo...">
                    </div>
                    <small class="input-hint">City, region, or property name</small>
                </div>

                <!-- Stay Type -->
                <div class="form-group">
                    <label for="hotel_type">Stay Type</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-house-chimney"></i>
                        <select id="hotel_type" name="type" style="width: 100%; padding: 0.75rem 0.85rem 0.75rem 2.4rem; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; color: var(--text); background: var(--bg); outline: none;">
                            <option value="all">All Accommodations</option>
                            <option value="hotel">Hotels Only</option>
                            <option value="airbnb">Airbnb Stays</option>
                        </select>
                    </div>
                </div>

                <!-- Max Price -->
                <div class="form-group">
                    <label for="price_max">Max Price Per Night ($)</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <input type="number" id="price_max" name="price_max" placeholder="e.g. 500">
                    </div>
                </div>

                <!-- Rating -->
                <div class="form-group">
                    <label for="hotel_rating">Min Rating</label>
                    <div class="input-icon-wrap">
                        <i class="fa-solid fa-star" style="color:#d97706;"></i>
                        <select id="hotel_rating" name="rating" style="width: 100%; padding: 0.75rem 0.85rem 0.75rem 2.4rem; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.95rem; font-family: inherit; color: var(--text); background: var(--bg); outline: none;">
                            <option value="">Any Rating</option>
                            <option value="4.8">★ 4.8 & Above</option>
                            <option value="4.5">★ 4.5 & Above</option>
                            <option value="4.0">★ 4.0 & Above</option>
                        </select>
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group" style="grid-column: span 1; justify-content: flex-end;">
                    <button type="submit" class="btn-search" id="hotelSearchBtn" style="margin-top: 0; padding: 0.75rem;">
                        <i class="fa-solid fa-magnifying-glass"></i> Search Stays
                    </button>
                </div>
            </div>
        </form>
    </div>
</div> <!-- Close search-card-wrap -->

<!-- STAY RECOMMENDATIONS -->
@if(isset($recommendedHotels) && !$recommendedHotels->isEmpty())
    <div class="page-content" style="padding-top: 1.5rem; padding-bottom: 0;">
        <div style="margin-bottom: 2rem;" class="fade-in-3">
            <div class="section-header" style="margin-bottom: 1.5rem;">
                <div>
                    <h2 class="section-title" style="font-size: 1.5rem; font-weight: 800; color: var(--text);">
                        Recommended <span style="color: var(--primary);">Stays for You</span>
                    </h2>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.25rem; display: flex; align-items: center; gap: 0.3rem;">
                        <i class="fa-solid fa-sparkles" style="color: #f59e0b;"></i> {{ $recommendationReason }}
                    </p>
                </div>
                <a href="{{ route('hotels.index') }}" class="section-link" style="font-size:0.85rem;">
                    Explore All Stays <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 1.5rem;">
                @foreach($recommendedHotels as $hotel)
                    <div class="destination-card" style="position: relative; border-radius: var(--radius); background: var(--white); box-shadow: var(--shadow); border: 1px solid var(--border); overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease;">
                        <div>
                            <!-- Card Image -->
                            <div class="card-image-wrap" style="position: relative; overflow: hidden;">
                                <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="card-image" style="height: 170px; width: 100%; object-fit: cover;" onerror="handleHotelImgError(this)">
                                <span class="card-badge" style="background: {{ $hotel->type == 'hotel' ? 'var(--primary)' : 'var(--accent)' }}; font-size: 0.65rem; padding: 0.2rem 0.55rem; top: 0.75rem; left: 0.75rem; border-radius:100px; text-transform:uppercase; font-weight:700; position:absolute; color:white; pointer-events:none;">
                                    ✦ {{ $hotel->type == 'hotel' ? 'Hotel' : 'Airbnb' }}
                                </span>
                            </div>

                            <!-- Card Content -->
                            <div class="card-content" style="padding: 1.25rem;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.4rem;">
                                    <div class="card-location" style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.25rem; margin-bottom: 0;">
                                        <i class="fa-solid fa-location-dot" style="color: var(--secondary); font-size: 0.7rem;"></i>
                                        {{ $hotel->location }}
                                    </div>
                                    <span class="rating-badge" style="background: #fef3c7; color: #d97706; font-size: 0.75rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.15rem;">
                                        <i class="fa-solid fa-star" style="font-size:0.7rem;"></i> {{ number_format($hotel->rating, 2) }}
                                    </span>
                                </div>
                                <div class="card-name" style="font-size: 1.05rem; font-weight: 700; color: var(--text); margin-bottom: 0.4rem;">{{ $hotel->name }}</div>
                                <div class="card-desc" style="font-size: 0.8rem; line-height: 1.5; color: var(--text-muted); margin-bottom: 0.75rem; height: 55px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $hotel->description }}
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer" style="padding: 1rem 1.25rem; background: var(--bg); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; border-radius: 0 0 var(--radius) var(--radius);">
                            <div>
                                <span class="card-price-label" style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; font-weight:600;">From</span>
                                <div style="color: var(--primary); font-size: 1.15rem; font-weight: 850;">${{ number_format($hotel->price_per_night) }}<span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 500;">/nt</span></div>
                            </div>
                            <a href="{{ route('hotels.show', $hotel->id) }}" class="btn-book" style="text-decoration: none; padding: 0.45rem 1rem; font-size: 0.8rem; border-radius: 100px; display:inline-block; font-weight:600;">
                                Book Stay <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem; margin-left: 0.15rem;"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Sponsored Advertisements (Full Screen Width) -->
@if(isset($advertisements) && $advertisements->count() > 0)
    <div class="sponsored-banner-section">
        <div class="sponsored-inner">
            <div class="section-header fade-in-3" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <h2 class="section-title">Sponsored <span>Partner Ads</span></h2>
                <span style="font-size: 0.72rem; color: var(--secondary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #e8f0fe; padding: 0.25rem 0.65rem; border-radius: 4px; border: 1.5px solid rgba(26,115,232,0.15); display: inline-flex; align-items: center; gap: 0.35rem; box-shadow: 0 2px 6px rgba(26,115,232,0.05);"><i class="fa-solid fa-rectangle-ad" style="font-size: 0.85rem"></i> Sponsored Spotlight</span>
            </div>
            
            <div class="results-grid fade-in-3" style="margin-top: 1rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 1.25rem;">
                @foreach($advertisements as $ad)
                    <div class="destination-card" style="position: relative; border-radius: 10px; background: var(--white); box-shadow: var(--shadow); border: 1px solid var(--border); overflow: hidden;">
                        <span style="position: absolute; top: 0.5rem; right: 0.5rem; background: rgba(28,28,46,0.85); color: white; backdrop-filter: blur(4px); font-size: 0.58rem; font-weight: 700; padding: 0.15rem 0.45rem; border-radius: 4px; border: 1px solid rgba(255,255,255,0.15); z-index: 5; text-transform: uppercase; letter-spacing: 0.05em;"><i class="fa-solid fa-star" style="color: #FFD166; margin-right: 0.15rem"></i> Sponsored</span>
                        
                        <div class="card-image-wrap">
                            <img src="{{ $ad->image_url }}" alt="{{ $ad->name }}" class="card-image" style="height: 125px; width: 100%; object-fit: cover;" loading="lazy" onerror="handleImgError(this)">
                            <span class="card-badge" style="background: var(--secondary); font-size: 0.6rem; padding: 0.2rem 0.5rem; top: 0.5rem; left: 0.5rem;">✦ Exclusive Offer</span>
                        </div>

                        <div class="card-content" style="padding: 0.85rem;">
                            <div class="card-location" style="font-size: 0.7rem; margin-bottom: 0.2rem;">
                                <i class="fa-solid fa-location-dot" style="color:#1A73E8;font-size:0.65rem;"></i>
                                {{ $ad->location }}
                            </div>
                            <div class="card-name" style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.3rem;">{{ $ad->name }}</div>
                            <div class="card-desc" style="font-size: 0.76rem; line-height: 1.45; margin-bottom: 0.6rem; height: 35px; -webkit-line-clamp: 2;">{{ $ad->description }}</div>

                            <!-- Budget bar -->
                            <div class="card-budget-bar" style="margin-bottom: 0.75rem; display: flex; align-items: center; justify-content: space-between; background: var(--bg); border-radius: 6px; padding: 0.35rem 0.55rem;">
                                <div class="card-budget-label" style="font-size: 0.68rem; color: var(--text-muted);">Est. Cost</div>
                                <div class="card-budget-range" style="color: var(--secondary); font-weight: 800; font-size: 0.78rem;">
                                    ${{ number_format($ad->min_budget) }} - ${{ number_format($ad->max_budget) }}
                                </div>
                            </div>

                            <div class="card-footer" style="padding-top: 0.65rem; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                                <div class="card-price" style="display: flex; flex-direction: column;">
                                    <span class="card-price-label" style="font-size: 0.65rem; color: var(--text-muted);">From</span>
                                    <span class="card-price-amount" style="color: var(--secondary); font-size: 1.05rem; font-weight: 800;">${{ number_format($ad->min_budget) }}</span>
                                </div>
                                <a href="#search" onclick="document.getElementById('departure').value = '{{ auth()->check() && isset(auth()->user()->preferences['preferred_airport']) ? auth()->user()->preferences['preferred_airport'] : 'New York (JFK)' }}'; document.getElementById('destination').value = '{{ $ad->name }}'; switchTab('flight-search', document.querySelectorAll('.search-tab')[1]);" class="btn-book" style="background: var(--secondary); text-decoration: none; padding: 0.4rem 0.9rem; font-size: 0.76rem; border-radius: 100px; display: inline-flex; align-items: center; gap: 0.25rem;">
                                    Fly Now <i class="fa-solid fa-plane"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- PAGE CONTENT -->
<div class="page-content">



    <!-- How it works -->
    <div id="how-it-works" style="margin-bottom:3rem;">
        <div class="section-header fade-in">
            <h2 class="section-title">How <span>TravelScape</span> works</h2>
        </div>
        <div class="how-grid fade-in-2">
            <div class="how-card">
                <div class="how-num">01</div>
                <div class="how-icon"><i class="fa-solid fa-wallet"></i></div>
                <h3>Set Your Budget</h3>
                <p>Enter your total spending limit and we'll filter destinations that actually fit.</p>
            </div>
            <div class="how-card">
                <div class="how-num">02</div>
                <div class="how-icon" style="background:#e8f0fe;color:#1A73E8"><i class="fa-regular fa-calendar"></i></div>
                <h3>Choose Your Dates</h3>
                <p>We use your travel months to match destinations that are best visited at that time.</p>
            </div>
            <div class="how-card">
                <div class="how-num">03</div>
                <div class="how-icon" style="background:#e6faf7;color:#00C9A7"><i class="fa-solid fa-heart"></i></div>
                <h3>Pick Your Interests</h3>
                <p>From adventure to culture — select activities you love for truly personal matches.</p>
            </div>
            <div class="how-card">
                <div class="how-num">04</div>
                <div class="how-icon" style="background:#fef9e7;color:#f59e0b"><i class="fa-solid fa-map-location-dot"></i></div>
                <h3>Get Matched Instantly</h3>
                <p>See curated destinations ranked by how well they match your preferences.</p>
            </div>
        </div>
    </div>

    <!-- Promo Banners -->
    <div class="section-header fade-in-3">
        <h2 class="section-title">Featured <span>Deals</span></h2>
        <a href="#search" class="section-link">Find yours <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="promo-grid fade-in-3">
        <div class="promo-card promo-1">
            <span>🔥 Budget Picks</span>
            <strong>Under $1,000 Trips</strong>
            <small>Amazing destinations that won't break the bank</small>
        </div>
        <div class="promo-card promo-2">
            <span>🌊 Summer Season</span>
            <strong>Beach & Island Getaways</strong>
            <small>Best destinations for June–August travel</small>
        </div>
        <div class="promo-card promo-3">
            <span>🏔️ Adventure Awaits</span>
            <strong>Trekking & Outdoor Picks</strong>
            <small>For the explorer in you — curated by activity</small>
        </div>
    </div>



</div>

<!-- FOOTER -->
<footer class="footer">
    <p>
        &copy; 2026 <span>TravelScape</span>. A personalized travel recommendation system
        built with Laravel 12. All rights reserved.
    </p>
</footer>

<script>
    const isUserLoggedIn = @json(auth()->check());
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').min = today;
    document.getElementById('start_date').addEventListener('change', function () {
        document.getElementById('end_date').min = this.value;
    });

    document.getElementById('searchForm').addEventListener('submit', function (e) {
        if (!isUserLoggedIn) {
            e.preventDefault();
            window.location.href = "{{ route('login') }}?info=" + encodeURIComponent("Please sign in to find your perfect destination.");
            return;
        }
        const btn = document.getElementById('searchBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Finding your matches…';
        btn.disabled = true;
    });

    // Flight search tab switching
    function switchTab(tabId, btn) {
        document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        document.getElementById('searchForm').style.display = 'none';
        document.getElementById('flightSearchForm').style.display = 'none';
        document.getElementById('hotelSearchForm').style.display = 'none';

        if (tabId === 'dest-finder') {
            document.getElementById('searchForm').style.display = 'block';
        } else if (tabId === 'flight-search') {
            document.getElementById('flightSearchForm').style.display = 'block';
        } else {
            document.getElementById('hotelSearchForm').style.display = 'block';
        }
    }

    // Flight search date limits and animations
    document.getElementById('flight_start_date').min = today;
    document.getElementById('flight_start_date').addEventListener('change', function () {
        document.getElementById('flight_end_date').min = this.value;
    });

    document.getElementById('flightSearchForm').addEventListener('submit', function (e) {
        if (!isUserLoggedIn) {
            e.preventDefault();
            window.location.href = "{{ route('login') }}?info=" + encodeURIComponent("Please sign in to search matching flights.");
            return;
        }
        const btn = document.getElementById('flightSearchBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Locating Flights…';
        btn.disabled = true;
    });

    document.getElementById('hotelSearchForm').addEventListener('submit', function (e) {
        if (!isUserLoggedIn) {
            e.preventDefault();
            window.location.href = "{{ route('login') }}?info=" + encodeURIComponent("Please sign in to search stays.");
            return;
        }
        const btn = document.getElementById('hotelSearchBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Finding Stays…';
        btn.disabled = true;
    });

    // Autocomplete dynamically from API instead of hardcoding
    const airportInputs = ['departure', 'destination'];
    airportInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        input.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length < 2) return;

            fetch(`/airports/suggest?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    const datalist = document.getElementById('airports-list');
                    datalist.innerHTML = ''; // Clear old static suggestions
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item;
                        datalist.appendChild(opt);
                    });
                })
                .catch(err => console.error("Error loading dynamic airport suggestions: ", err));
        });
    });

    // Premium Hero Background Slideshow Loop
    (function() {
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length > 0) {
            let current = 0;
            setInterval(function() {
                slides[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
            }, 5000);
        }
    })();
</script>


</body>
</html>
