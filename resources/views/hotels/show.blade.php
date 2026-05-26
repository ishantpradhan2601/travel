<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hotel->name }} – TravelScape</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Details layout */
        .show-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 2.5rem;
            margin-top: 2rem;
        }
        @media (max-width: 992px) {
            .show-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Large Hero Banner */
        .details-hero {
            position: relative;
            height: 380px;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        .details-hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .details-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.55) 100%);
        }
        .details-hero-info {
            position: absolute;
            bottom: 2rem;
            left: 2.5rem;
            right: 2.5rem;
            color: white;
        }

        /* Back Button floating */
        .floating-back-btn {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            background: rgba(28,28,46,0.75);
            color: white !important;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 0.5rem 1.1rem;
            border-radius: 100px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 10;
            transition: all 0.2s;
        }
        .floating-back-btn:hover {
            transform: translateX(-3px);
            background: rgba(255,90,48,0.9);
        }

        /* Amenities icons */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }
        .amenity-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0.9rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow);
        }
        .amenity-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }
        .amenity-card span {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
        }

        /* Booking Sidebar Card */
        .booking-checkout-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            padding: 1.75rem;
            height: fit-content;
            position: sticky;
            top: 80px;
        }
        
        /* Interactive dynamic pricing breakdown */
        .pricing-breakdown {
            background: var(--bg);
            border-radius: var(--radius-sm);
            padding: 1rem;
            border: 1.5px dashed var(--border);
            margin: 1.25rem 0;
            display: none; /* Injected by Javascript */
        }
        .pricing-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }
        .pricing-row:last-child {
            margin-bottom: 0;
        }
        .pricing-total {
            font-size: 1.2rem;
            font-weight: 850;
            color: var(--primary);
        }

        /* Leaflet vector map mockup */
        .map-mockup {
            height: 200px;
            background: #e3eaec;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            margin-top: 1.5rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .map-grid-lines {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(circle, #cbd5e1 1.5px, transparent 1.5px),
                linear-gradient(rgba(203,213,225,0.2) 1px, transparent 1px),
                linear-gradient(90deg, rgba(203,213,225,0.2) 1px, transparent 1px);
            background-size: 16px 16px, 32px 32px, 32px 32px;
        }
        .map-marker {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            position: relative;
            z-index: 5;
            box-shadow: 0 4px 10px rgba(255,90,48,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 2s infinite ease-in-out;
        }
        .map-marker::after {
            content: '';
            width: 14px;
            height: 14px;
            background: white;
            border-radius: 50%;
            transform: rotate(45deg);
        }
        .map-radar {
            position: absolute;
            width: 70px;
            height: 70px;
            background: rgba(255,90,48,0.18);
            border-radius: 50%;
            z-index: 2;
            animation: radar 2.5s infinite linear;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0) rotate(-45deg); }
            50% { transform: translateY(-8px) rotate(-45deg); }
        }
        @keyframes radar {
            0% { transform: scale(0.3); opacity: 1; }
            100% { transform: scale(1.6); opacity: 0; }
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

<!-- MAIN CONTAINER -->
<div class="page-content">
    
    <!-- DETAILS HERO -->
    <div class="details-hero fade-in">
        <a href="{{ route('hotels.index') }}" class="floating-back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Listings
        </a>
        <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="details-hero-img" onerror="handleImgError(this)">
        <div class="details-hero-overlay"></div>
        <div class="details-hero-info">
            <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:0.4rem;">
                <span class="hotel-type-badge {{ $hotel->type }}" style="margin-bottom:0;">
                    {{ $hotel->type == 'hotel' ? 'Hotel Stay' : 'Airbnb Stay' }}
                </span>
                <span class="rating-badge" style="background:#d97706; color:white;">
                    <i class="fa-solid fa-star"></i> {{ number_format($hotel->rating, 2) }} Rating
                </span>
            </div>
            <h1 style="font-size:2rem; font-weight:800; text-shadow:0 2px 10px rgba(0,0,0,0.3);">{{ $hotel->name }}</h1>
            <p style="margin-top:0.25rem; font-weight:500; font-size:0.95rem; text-shadow:0 1px 8px rgba(0,0,0,0.3); display:flex; align-items:center; gap:0.3rem;">
                <i class="fa-solid fa-location-dot" style="color:#FFD166;"></i> {{ $hotel->location }}
            </p>
        </div>
    </div>

    <!-- SHOW LAYOUT -->
    <div class="show-layout">
        
        <!-- LEFT: MAIN INFO -->
        <div class="fade-in-2">
            <!-- Description -->
            <div style="background:var(--white); border-radius:var(--radius); border:1px solid var(--border); box-shadow:var(--shadow); padding:2rem; margin-bottom:2rem;">
                <h2 style="font-size:1.3rem; font-weight:700; color:var(--text); margin-bottom:0.75rem;">About this Property</h2>
                <p style="font-size:0.92rem; line-height:1.65; color:var(--text-muted); white-space:pre-line;">
                    {{ $hotel->description }}
                </p>
            </div>

            <!-- Amenities -->
            <div style="background:var(--white); border-radius:var(--radius); border:1px solid var(--border); box-shadow:var(--shadow); padding:2rem; margin-bottom:2rem;">
                <h2 style="font-size:1.3rem; font-weight:700; color:var(--text); margin-bottom:0.5rem;">Offered Amenities</h2>
                <p style="font-size:0.83rem; color:var(--text-muted);">Fully provisioned and vetted utilities for your absolute comfort:</p>
                
                <div class="amenities-grid">
                    @if($hotel->amenities)
                        @php
                            // Match amenities with matching icons
                            $iconMap = [
                                'Wifi' => 'fa-wifi',
                                'Pool' => 'fa-water-ladder',
                                'Spa' => 'fa-spa',
                                'Restaurant' => 'fa-utensils',
                                'Air Conditioning' => 'fa-snowflake',
                                'Free Parking' => 'fa-square-parking',
                                'Kitchen' => 'fa-kitchen-set',
                                'Gym' => 'fa-dumbbell',
                                'Bar' => 'fa-martini-glass-citrus',
                                'Free Breakfast' => 'fa-mug-hot',
                                'Hot Tub' => 'fa-hot-tub-person',
                                'Fireplace' => 'fa-fire',
                                'Washing Machine' => 'fa-soap',
                                'Balcony' => 'fa-door-open',
                                'Water Slide' => 'fa-water',
                                'Ski Access' => 'fa-person-skiing',
                                'Pocket Wifi' => 'fa-mobile-screen-button',
                                'Pet Friendly' => 'fa-paw',
                                'Room Service' => 'fa-bell-concierge',
                                'Fitness Center' => 'fa-dumbbell'
                            ];
                        @endphp
                        @foreach($hotel->amenities as $am)
                            <div class="amenity-card">
                                <div class="amenity-icon-wrap">
                                    <i class="fa-solid {{ $iconMap[$am] ?? 'fa-circle-check' }}"></i>
                                </div>
                                <span>{{ $am }}</span>
                            </div>
                        @endforeach
                    @else
                        <p style="font-size:0.88rem; color:var(--text-muted);">Standard check-in facilities available.</p>
                    @endif
                </div>
            </div>

            <!-- Location Map -->
            <div style="background:var(--white); border-radius:var(--radius); border:1px solid var(--border); box-shadow:var(--shadow); padding:2rem;">
                <h2 style="font-size:1.3rem; font-weight:700; color:var(--text); margin-bottom:0.25rem;">Property Location</h2>
                <span style="font-size:0.75rem; color:var(--text-muted); font-weight:500; font-family:monospace; text-transform:uppercase;">
                    Latitude: {{ $hotel->latitude ?? 'N/A' }} · Longitude: {{ $hotel->longitude ?? 'N/A' }}
                </span>
                
                <div class="map-mockup">
                    <div class="map-grid-lines"></div>
                    <div class="map-radar"></div>
                    <div class="map-marker"></div>
                    
                    <!-- Floating Map Card -->
                    <div style="position: absolute; bottom: 0.75rem; left: 0.75rem; background: rgba(28,28,46,0.9); color: white; padding: 0.5rem 0.85rem; border-radius: 6px; font-size: 0.72rem; z-index: 10; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(4px);">
                        <i class="fa-solid fa-map" style="color:var(--primary); margin-right:0.25rem;"></i> High-Accuracy GPS Resolved
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: BOOKING CARD -->
        <div class="fade-in-3">
            <div class="booking-checkout-card">
                <div style="display:flex; align-items:baseline; gap:0.25rem; border-bottom:1px solid var(--border); padding-bottom:1rem; margin-bottom:1.25rem;">
                    <span style="font-size:1.5rem; font-weight:850; color:var(--primary);">${{ number_format($hotel->price_per_night) }}</span>
                    <span style="font-size:0.83rem; color:var(--text-muted); font-weight:500;">/ night</span>
                </div>

                <form action="{{ route('hotels.book', $hotel->id) }}" method="POST" id="bookingForm">
                    @csrf
                    
                    <!-- Passenger Name -->
                    <div class="form-group" style="margin-bottom:0.85rem;">
                        <label for="customer_name">Lead Guest Name</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="customer_name" name="customer_name" required placeholder="e.g. Jane Doe"
                                   value="{{ old('customer_name', auth()->check() ? auth()->user()->name : '') }}">
                        </div>
                    </div>

                    <!-- Passenger Email -->
                    <div class="form-group" style="margin-bottom:0.85rem;">
                        <label for="customer_email">Guest Email Address</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="customer_email" name="customer_email" required placeholder="e.g. jane@example.com"
                                   value="{{ old('customer_email', auth()->check() ? auth()->user()->email : '') }}">
                        </div>
                    </div>

                    <!-- Dates Row -->
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; margin-bottom:0.85rem;">
                        <div class="form-group">
                            <label for="start_date">Check-In</label>
                            <div class="input-icon-wrap">
                                <i class="fa-regular fa-calendar-check" style="left:0.65rem;"></i>
                                <input type="date" id="start_date" name="start_date" required style="padding-left:1.8rem; font-size:0.8rem;" class="date-picker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Check-Out</label>
                            <div class="input-icon-wrap">
                                <i class="fa-regular fa-calendar-xmark" style="left:0.65rem;"></i>
                                <input type="date" id="end_date" name="end_date" required style="padding-left:1.8rem; font-size:0.8rem;" class="date-picker">
                            </div>
                        </div>
                    </div>

                    <!-- Travelers -->
                    <div class="form-group" style="margin-bottom:0.85rem;">
                        <label for="travelers">Guests Count</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-users"></i>
                            <input type="number" id="travelers" name="travelers" required min="1" max="10" value="1">
                        </div>
                    </div>

                    <!-- Dynamic Price Breakdown (Injected by JS) -->
                    <div id="breakdown" class="pricing-breakdown">
                        <div class="pricing-row">
                            <span id="rateLabel">$120 x 1 night</span>
                            <span id="subTotal">$120</span>
                        </div>
                        <div class="pricing-row" style="border-top:1px solid var(--border); padding-top:0.4rem; margin-top:0.4rem; font-weight:700;">
                            <span>Total Price (USD)</span>
                            <span class="pricing-total" id="finalTotal">$120</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-search" style="width:100%; margin-top:1rem; padding:0.85rem;" id="submitBtn">
                        <i class="fa-solid fa-credit-card"></i> Book This Stay Instantly
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- FOOTER -->
<footer class="footer">
    <p>
        &copy; 2026 <span>TravelScape</span>. A premium hotel and stay finder powered by Laravel 12. All rights reserved.
    </p>
</footer>

<script>
    const today = new Date().toISOString().split('T')[0];
    const checkin = document.getElementById('start_date');
    const checkout = document.getElementById('end_date');
    const guests = document.getElementById('travelers');
    const form = document.getElementById('bookingForm');
    const submitBtn = document.getElementById('submitBtn');
    
    checkin.min = today;
    checkin.addEventListener('change', function () {
        checkout.min = this.value;
        calculatePrice();
    });
    checkout.addEventListener('change', calculatePrice);
    guests.addEventListener('input', calculatePrice);

    form.addEventListener('submit', function () {
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Reserving Stay…';
        submitBtn.disabled = true;
    });

    const pricePerNight = {{ $hotel->price_per_night }};

    function calculatePrice() {
        const checkinVal = checkin.value;
        const checkoutVal = checkout.value;
        const guestsCount = parseInt(guests.value) || 1;

        if (!checkinVal || !checkoutVal) return;

        const date1 = new Date(checkinVal);
        const date2 = new Date(checkoutVal);

        const diffTime = Math.abs(date2 - date1);
        let nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (nights === 0) nights = 1; // minimum 1 night charge

        const rawPrice = pricePerNight * nights;
        
        // Show breakdown block
        const bd = document.getElementById('breakdown');
        bd.style.display = 'block';

        // Update values
        document.getElementById('rateLabel').innerText = `$${pricePerNight.toLocaleString()} x ${nights} night${nights !== 1 ? 's' : ''}`;
        document.getElementById('subTotal').innerText = `$${rawPrice.toLocaleString()}`;
        document.getElementById('finalTotal').innerText = `$${rawPrice.toLocaleString()}`;
    }
</script>

</body>
</html>
