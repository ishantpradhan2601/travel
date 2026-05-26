<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Accommodations – TravelScape</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .hotels-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        @media (max-width: 992px) {
            .hotels-container {
                grid-template-columns: 1fr;
            }
        }
        
        /* Sidebar Filter Card */
        .filter-sidebar {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 80px;
            max-height: calc(100vh - 110px);
            overflow-y: auto;
        }
        .filter-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .filter-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .filter-sidebar::-webkit-scrollbar-thumb {
            background-color: var(--border);
            border-radius: 10px;
        }
        .filter-sidebar::-webkit-scrollbar-thumb:hover {
            background-color: var(--text-muted);
        }
        .filter-section {
            border-bottom: 1px solid var(--border);
            padding-bottom: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .filter-section:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .filter-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.88rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
        }
        .checkbox-label:hover {
            color: var(--primary);
        }
        .checkbox-label input {
            accent-color: var(--primary);
            cursor: pointer;
            width: 16px;
            height: 16px;
        }
        .select-input {
            width: 100%;
            padding: 0.65rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-family: inherit;
            color: var(--text);
            background: var(--bg);
            outline: none;
            transition: border-color 0.2s;
        }
        .select-input:focus {
            border-color: var(--primary);
        }
        .price-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        .price-inputs input {
            width: 100%;
            padding: 0.55rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            background: var(--bg);
            color: var(--text);
            font-family: inherit;
            outline: none;
        }
        .price-inputs input:focus {
            border-color: var(--primary);
        }

        /* Hotels Grid Card Custom Styling */
        .hotel-grid-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
        }
        .hotel-grid-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        .hotel-img-wrap {
            width: 260px;
            position: relative;
            flex-shrink: 0;
        }
        .hotel-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hotel-details {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        @media (max-width: 600px) {
            .hotel-grid-card {
                flex-direction: column;
            }
            .hotel-img-wrap {
                width: 100%;
                height: 180px;
            }
        }
        .hotel-type-badge {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.2rem 0.55rem;
            border-radius: 4px;
            color: white;
            display: inline-block;
            margin-bottom: 0.4rem;
        }
        .hotel-type-badge.hotel {
            background: var(--primary);
        }
        .hotel-type-badge.airbnb {
            background: var(--accent);
        }
        .rating-badge {
            background: #fef3c7;
            color: #d97706;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
        }
        .hotel-amenities {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            margin: 0.75rem 0;
        }
        .hotel-amenity-tag {
            font-size: 0.72rem;
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
        }
        .btn-filter-apply {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: background 0.2s;
        }
        .btn-filter-apply:hover {
            background: var(--primary-dark);
        }
        .btn-filter-reset {
            background: none;
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 0.55rem;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 0.5rem;
            transition: all 0.2s;
        }
        .btn-filter-reset:hover {
            background: var(--bg);
            color: var(--text);
        }
    </style>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();

        function handleImgError(img) {
            img.onerror = null;
            const hotelBackups = [
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80'
            ];
            img.src = hotelBackups[Math.floor(Math.random() * hotelBackups.length)];
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
            <li><a href="{{ route('home') }}">Find Destinations</a></li>
            <li><a href="{{ route('hotels.index') }}" class="active">Hotels & Airbnbs</a></li>
            <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            @auth
                <li><span style="color: var(--text); font-size: 0.9rem; font-weight: 600; padding: 0.5rem 0.9rem; display: inline-flex; align-items: center; gap: 0.45rem;"><i class="fa-solid fa-circle-user" style="color: var(--primary); font-size: 1.05rem;"></i> {{ auth()->user()->name }}</span></li>
            @else
                <li><a href="{{ route('login') }}" class="nav-cta"><i class="fa-solid fa-user"></i> Sign In</a></li>
            @endauth
        </ul>
    </div>
</nav>

<!-- MINI HERO -->
<div style="position: relative; background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat; padding: 4.5rem 1.5rem 5.5rem; text-align: center; color: white; overflow: hidden; box-shadow: var(--shadow);">
    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(28,28,46,0.88) 0%, rgba(255,90,48,0.55) 100%); z-index: 1;"></div>
    <div style="position: relative; z-index: 2;">
        <h1 style="font-size: 2.6rem; font-weight: 800; margin-bottom: 0.5rem; text-shadow: 0 2px 12px rgba(0,0,0,0.4);">Explore Worldwide Accommodations</h1>
        <p style="opacity: 0.92; font-size: 1.05rem; max-width: 650px; margin: 0 auto; text-shadow: 0 1px 8px rgba(0,0,0,0.4); font-weight: 500;">Book luxury 5-star hotels or charming home-styled Airbnbs perfectly located in top global spots.</p>
    </div>
</div>

<!-- CONTAINER -->
<div class="page-content" style="margin-top: -30px;">
    
    <div class="hotels-container">
        
        <!-- SIDEBAR FILTERS -->
        <aside class="filter-sidebar fade-in">
            <form action="{{ route('hotels.index') }}" method="GET" id="filterForm">
                
                <!-- Search Location -->
                <div class="filter-section">
                    <label class="filter-title">Where To?</label>
                    <div class="input-icon-wrap" style="margin-top:0.3rem;">
                        <i class="fa-solid fa-location-dot" style="left:0.65rem;"></i>
                        <input type="text" name="location" placeholder="Search city or hotel..." 
                               value="{{ request('location') }}" class="select-input" style="padding-left:1.8rem; background: var(--bg);">
                    </div>
                </div>

                <!-- Stay Type -->
                <div class="filter-section">
                    <label class="filter-title">Property Type</label>
                    <select name="type" class="select-input">
                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Accommodations</option>
                        <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotels Only</option>
                        <option value="airbnb" {{ request('type') == 'airbnb' ? 'selected' : '' }}>Airbnb / Stays</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="filter-section">
                    <label class="filter-title">Price Per Night ($)</label>
                    <div class="price-inputs">
                        <input type="number" name="price_min" placeholder="Min" min="0" value="{{ request('price_min') }}">
                        <input type="number" name="price_max" placeholder="Max" min="0" value="{{ request('price_max') }}">
                    </div>
                </div>

                <!-- Rating -->
                <div class="filter-section">
                    <label class="filter-title">Minimum Rating</label>
                    <select name="rating" class="select-input">
                        <option value="" {{ request('rating') == '' ? 'selected' : '' }}>Any Rating</option>
                        <option value="4.8" {{ request('rating') == '4.8' ? 'selected' : '' }}>★ 4.8 & Above</option>
                        <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>★ 4.5 & Above</option>
                        <option value="4.0" {{ request('rating') == '4.0' ? 'selected' : '' }}>★ 4.0 & Above</option>
                    </select>
                </div>

                <!-- Amenities -->
                <div class="filter-section">
                    <label class="filter-title">Amenities</label>
                    <div class="filter-options">
                        @foreach($allAmenities as $amenity)
                            <label class="checkbox-label">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity }}"
                                    {{ is_array(request('amenities')) && in_array($amenity, request('amenities')) ? 'checked' : '' }}>
                                <span>{{ $amenity }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Submit & Reset Buttons -->
                <div class="filter-section">
                    <button type="submit" class="btn-filter-apply">
                        <i class="fa-solid fa-filter"></i> Apply Filters
                    </button>
                    <a href="{{ route('hotels.index') }}" class="btn-filter-reset" style="text-decoration:none; display:block; text-align:center;">
                        <i class="fa-solid fa-arrow-rotate-right"></i> Reset Filters
                    </a>
                </div>

            </form>
        </aside>

        <!-- HOTELS CONTENT -->
        <main style="display: flex; flex-direction: column; gap: 1.5rem;" class="fade-in-2">
            
            <!-- Result Bar -->
            <div class="results-bar" style="margin-bottom:0;">
                <div class="results-bar-info">
                    <i class="fa-solid fa-hotel" style="color:var(--primary);"></i>
                    <span class="results-count">{{ $hotels->count() }} propert{{ $hotels->count() != 1 ? 'ies' : 'y' }} found</span>
                </div>
                <div style="display:flex; align-items:center; gap:0.5rem;">
                    <label style="font-size:0.78rem; font-weight:600; color:var(--text-muted); text-transform:uppercase;">Sort By:</label>
                    <select name="sort" class="select-input" onchange="document.getElementById('sortInput').value = this.value; document.getElementById('filterForm').submit();" style="width:160px; padding:0.4rem 0.5rem; font-size:0.8rem;">
                        <option value="recommended" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Customer Rating</option>
                    </select>
                    <input type="hidden" name="sort" id="sortInput" form="filterForm" value="{{ request('sort', 'recommended') }}">
                </div>
            </div>

            @if($hotels->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-house-circle-exclamation" style="color:var(--border);"></i>
                    <h2>No properties match your filters</h2>
                    <p>Try widening your search terms, adjusting the price sliders, or selecting fewer amenities.</p>
                    <a href="{{ route('hotels.index') }}" class="btn-outline">
                        Show All Accommodations
                    </a>
                </div>
            @else
                <!-- Grid list -->
                @foreach($hotels as $hotel)
                    <div class="hotel-grid-card">
                        <!-- Left Image -->
                        <div class="hotel-img-wrap">
                            <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="hotel-img" onerror="handleImgError(this)">
                            <div style="position: absolute; top:0.75rem; left:0.75rem;">
                                <span class="hotel-type-badge {{ $hotel->type }}">
                                    {{ $hotel->type == 'hotel' ? '✦ Hotel' : '✦ Airbnb' }}
                                </span>
                            </div>
                        </div>

                        <!-- Right Info -->
                        <div class="hotel-details">
                            <div>
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.35rem;">
                                    <span style="font-size: 0.76rem; color: var(--text-muted); font-weight:600; display:flex; align-items:center; gap:0.25rem;">
                                        <i class="fa-solid fa-location-dot" style="color:var(--secondary)"></i> {{ $hotel->location }}
                                    </span>
                                    <span class="rating-badge">
                                        <i class="fa-solid fa-star"></i> {{ number_format($hotel->rating, 2) }}
                                    </span>
                                </div>
                                
                                <h3 style="font-size:1.15rem; font-weight:800; color:var(--text); margin-bottom:0.4rem;">{{ $hotel->name }}</h3>
                                <p style="font-size:0.83rem; line-height:1.5; color:var(--text-muted); margin-bottom:0.75rem;">
                                    {{ Str::limit($hotel->description, 160) }}
                                </p>

                                <div class="hotel-amenities">
                                    @if($hotel->amenities)
                                        @foreach(array_slice($hotel->amenities, 0, 5) as $am)
                                            <span class="hotel-amenity-tag">{{ $am }}</span>
                                        @endforeach
                                        @if(count($hotel->amenities) > 5)
                                            <span class="hotel-amenity-tag" style="background:var(--primary-light); color:var(--primary); font-weight:600;">+{{ count($hotel->amenities) - 5 }} More</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer" style="padding-top:0.75rem; border-top:1px solid var(--border); margin-top:0.5rem; display:flex; align-items:center; justify-content:space-between;">
                                <div>
                                    <span style="font-size:0.65rem; color:var(--text-muted); text-transform:uppercase; font-weight:700;">Price Per Night</span>
                                    <div style="font-size:1.25rem; font-weight:850; color:var(--primary);">${{ number_format($hotel->price_per_night) }}</div>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn-book" style="text-decoration:none; padding:0.55rem 1.35rem;">
                                    View Details <i class="fa-solid fa-arrow-right" style="font-size:0.75rem; margin-left:0.15rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </main>
        
    </div>
    
</div>

<!-- FOOTER -->
<footer class="footer">
    <p>
        &copy; 2026 <span>TravelScape</span>. A premium hotel and stay finder powered by Laravel 12. All rights reserved.
    </p>
</footer>

</body>
</html>
