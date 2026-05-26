<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results – TravelScape</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .flights-grid {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-top: 1.5rem;
        }
        .flight-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            padding: 1.5rem 2rem;
            display: grid;
            grid-template-columns: 2fr 3fr 2fr;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.25s ease;
            position: relative;
        }
        .flight-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        .airline-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .airline-logo-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            border: 1px solid rgba(255,90,48,0.15);
        }
        .airline-name {
            font-weight: 700;
            color: var(--text);
            font-size: 1.05rem;
            margin-bottom: 0.15rem;
        }
        .flight-num {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-family: monospace;
            font-weight: 600;
        }
        .route-timeline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            position: relative;
        }
        .time-block h4 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--text);
            margin: 0 0 0.15rem 0;
        }
        .time-block span {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .timeline-graphic {
            flex: 1;
            padding: 0 1.5rem;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
        }
        .timeline-line {
            width: 100%;
            height: 2px;
            background: var(--border);
            position: relative;
        }
        .timeline-line::before, .timeline-line::after {
            content: '';
            position: absolute;
            top: -3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--border);
        }
        .timeline-line::before { left: 0; }
        .timeline-line::after { right: 0; background: var(--primary); }
        .timeline-line i {
            position: absolute;
            top: -7px;
            left: 50%;
            transform: translateX(-50%);
            color: var(--primary);
            background: white;
            padding: 0 4px;
            font-size: 0.85rem;
        }
        .timeline-duration {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
        }
        .timeline-stops {
            font-size: 0.72rem;
            color: #00C9A7;
            font-weight: 700;
            background: #e6faf7;
            padding: 0.15rem 0.5rem;
            border-radius: 100px;
            letter-spacing: 0.02em;
        }
        .timeline-stops.non-stop {
            color: var(--secondary);
            background: #e8f0fe;
        }
        .pricing-action {
            text-align: right;
            border-left: 1px solid var(--border);
            padding-left: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
        }
        .flight-price {
            display: flex;
            flex-direction: column;
        }
        .flight-price-amount {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }
        .flight-price-label {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 0.2rem;
        }

        .flight-sort-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            border-radius: var(--radius-sm);
            padding: 0.75rem 1.25rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            margin-top: 1.5rem;
        }
        .sort-options {
            display: flex;
            gap: 0.5rem;
        }
        .sort-btn {
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 0.45rem 1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .sort-btn.active {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
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
            const airplanes = [
                'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1540962351504-03099e0a754b?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1506012787146-f92b2d7d6d96?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1473862170180-84427c485ade?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1483450388369-9ed95738483c?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1524850301259-7729d41d11d9?auto=format&fit=crop&w=800&q=80'
            ];
            img.src = airplanes[Math.floor(Math.random() * airplanes.length)];
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
            <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            @auth
                <li><span style="color: var(--text); font-size: 0.9rem; font-weight: 600; padding: 0.5rem 0.9rem; display: inline-flex; align-items: center; gap: 0.45rem;"><i class="fa-solid fa-circle-user" style="color: var(--primary); font-size: 1.05rem;"></i> {{ auth()->user()->name }}</span></li>
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

<!-- RESULTS HERO -->
<div class="results-hero">
    <div class="results-hero-inner">
        <div class="results-hero-icon"><i class="fa-solid fa-plane-departure"></i></div>
        <div>
            <p class="results-hero-label">Available Flight Matches</p>
            <h1 class="results-hero-title">
                {{ $depCity }} ({{ $depCode }}) ➔ {{ $destCity }} ({{ $destCode }})
            </h1>
            <p class="results-hero-sub">
                Departure: <strong>{{ date('d M, Y', strtotime($departureDate)) }}</strong>
                @if($returnDate)
                    · Return: <strong>{{ date('d M, Y', strtotime($returnDate)) }}</strong>
                @endif
                · Travelers: <strong>{{ $travelers }} {{ Str::plural('pax', $travelers) }}</strong>
            </p>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="page-content" style="margin-top:-50px;">

    <!-- Flight Sort and Filter -->
    <div class="flight-sort-bar fade-in">
        <div style="font-size:0.9rem;font-weight:600;color:var(--text)">
            <i class="fa-solid fa-sliders" style="color:var(--primary);margin-right:0.3rem"></i>
            {{ count($flights) }} flights found
        </div>
        <div class="sort-options">
            <button class="sort-btn active" onclick="sortFlights('cheapest')">Cheapest</button>
            <button class="sort-btn" onclick="sortFlights('fastest')">Fastest</button>
            <button class="sort-btn" onclick="sortFlights('best')">Best Value</button>
        </div>
    </div>

    <!-- Flight Offers Grid -->
    <div class="flights-grid">
        @foreach($flights as $i => $flight)
            <div class="flight-card fade-in" style="animation-delay:{{ $i * 0.08 }}s">
                <!-- Left: Airline info -->
                <div class="airline-info">
                    <div class="airline-logo-wrap">
                        <i class="fa-solid {{ $flight['logo'] }}"></i>
                    </div>
                    <div>
                        <div class="airline-name">{{ $flight['airline'] }}</div>
                        <div class="flight-num">{{ $flight['flight_number'] }} · {{ $flight['class'] }}</div>
                    </div>
                </div>

                <!-- Center: Flight Route Timeline -->
                <div class="route-timeline">
                    <div class="time-block">
                        <h4>{{ $flight['departure_time'] }}</h4>
                        <span>{{ $depCode }}</span>
                    </div>

                    <div class="timeline-graphic">
                        <span class="timeline-duration">{{ $flight['duration'] }}</span>
                        <div class="timeline-line">
                            <i class="fa-solid fa-plane"></i>
                        </div>
                        <span class="timeline-stops {{ $flight['type'] == 'Direct' ? 'non-stop' : '' }}">
                            {{ $flight['stops'] }}
                        </span>
                    </div>

                    <div class="time-block">
                        <h4>{{ $flight['arrival_time'] }}</h4>
                        <span>{{ $destCode }}</span>
                    </div>
                </div>

                <!-- Right: Pricing & Booking -->
                <div class="pricing-action">
                    <div class="flight-price">
                        <span class="flight-price-amount">${{ number_format($flight['price']) }}</span>
                        <span class="flight-price-label">per traveler</span>
                    </div>
                    <button class="btn-book" onclick="openFlightDrawer(
                        '{{ $flight['airline'] }}',
                        '{{ $flight['flight_number'] }}',
                        '{{ $flight['price'] }}'
                    )">
                        Select Ticket <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Back to search CTA -->
    <div style="text-align:center;margin-top:3rem;padding:2.5rem;background:white;border-radius:16px;border:1px solid #e5e7eb;box-shadow:0 2px 16px rgba(0,0,0,0.05);" class="fade-in">
        <i class="fa-solid fa-plane" style="font-size:2rem;color:var(--primary);margin-bottom:1rem;display:block;"></i>
        <h3 style="font-size:1.2rem;font-weight:700;margin-bottom:0.4rem;">Not what you were looking for?</h3>
        <p style="color:#6b7280;font-size:0.9rem;margin-bottom:1.25rem;">
            Refine your departure dates, destinations, or passenger count to check other routes.
        </p>
        <a href="{{ route('home') }}" class="btn-outline">
            <i class="fa-solid fa-rotate-left"></i> Start a New Search
        </a>
    </div>

</div>

<!-- SLIDE-UP FLIGHT CHECKOUT DRAWER / MODAL -->
<div id="bookingDrawerOverlay" class="drawer-overlay" onclick="closeBookingDrawer()"></div>
<div id="bookingDrawer" class="booking-drawer">
    <div class="drawer-header">
        <div>
            <h3>Book Flight Ticket</h3>
            <p style="font-size: 0.82rem; color: var(--text-muted);">Confirm flight boarding details</p>
        </div>
        <button class="drawer-close" onclick="closeBookingDrawer()"><i class="fa-solid fa-xmark"></i></button>
    </div>
    
    <div class="drawer-body">
        <div class="drawer-layout">
            <!-- Left: Checkout Form -->
            <form action="{{ route('flights.book') }}" method="POST" id="flightCheckoutForm">
                @csrf
                <input type="hidden" name="airline" id="formAirline">
                <input type="hidden" name="flight_number" id="formFlightNum">
                <input type="hidden" name="departure_city" value="{{ $depCity }}">
                <input type="hidden" name="destination_city" value="{{ $destCity }}">
                <input type="hidden" name="departure_code" value="{{ $depCode }}">
                <input type="hidden" name="destination_code" value="{{ $destCode }}">
                <input type="hidden" name="departure_date" value="{{ $departureDate }}">
                <input type="hidden" name="return_date" value="{{ $returnDate }}">
                <input type="hidden" name="price" id="formPrice">
                <input type="hidden" name="travelers" value="{{ $travelers }}">

                <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group full" style="grid-column: span 2;">
                        <label for="customer_name">Primary Passenger Name</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" id="customer_name" name="customer_name" placeholder="e.g. Ishan Pradhan" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group full" style="grid-column: span 2;">
                        <label for="customer_email">Email Address</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="customer_email" name="customer_email" placeholder="e.g. ishan@example.com" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                        </div>
                    </div>

                    <div class="form-group full" style="grid-column: span 2;">
                        <label for="passport_num">Passport / National ID Number</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-id-card"></i>
                            <input type="text" id="passport_num" placeholder="e.g. A12345678" required>
                        </div>
                        <small class="input-hint">Required for secure boarding pass generation</small>
                    </div>
                </div>

                <div class="booking-summary-box">
                    <div class="summary-line">
                        <span>Passenger Cost (x{{ $travelers }} traveler(s))</span>
                        <strong id="summaryBasePrice">$0</strong>
                    </div>
                    <div class="summary-line highlight">
                        <span>Grand Total</span>
                        <strong id="summaryTotalPrice">$0</strong>
                    </div>
                </div>

                <button type="submit" class="btn-search" style="margin-top: 1rem;">
                    <i class="fa-solid fa-credit-card"></i> Confirm &amp; Reserve Flight Tickets
                </button>
            </form>
            
            <!-- Right: Dynamic Boarding Preview Card -->
            <div class="drawer-preview-card">
                <img id="drawerDestImg" src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=800&q=80" alt="Destination Image" onerror="handleImgError(this)">
                <div class="preview-card-info">
                    <span class="preview-badge"><i class="fa-solid fa-plane"></i> Dynamic Boarding Preview</span>
                    <h4 id="previewAirline">Airline</h4>
                    <p>{{ $depCode }} ➔ {{ $destCode }} · Flight Number: <span id="previewFlightNum" style="font-family:monospace;font-weight:700">LH-100</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer" style="margin-top:4rem">
    <p>
        &copy; 2026 <span>TravelScape</span>. A personalized travel recommendation system
        built with Laravel 12. All rights reserved.
    </p>
</footer>

<script>
    let basePricePerTraveler = 0;
    const numTravelers = {{ $travelers }};

    function openFlightDrawer(airline, flightNum, price) {
        document.getElementById('formAirline').value = airline;
        document.getElementById('formFlightNum').value = flightNum;
        document.getElementById('formPrice').value = price;

        document.getElementById('previewAirline').innerText = airline;
        document.getElementById('previewFlightNum').innerText = flightNum;

        basePricePerTraveler = price;
        const total = price * numTravelers;

        document.getElementById('summaryBasePrice').innerText = '$' + (price * 1).toLocaleString();
        document.getElementById('summaryTotalPrice').innerText = '$' + total.toLocaleString();

        document.getElementById('bookingDrawerOverlay').classList.add('active');
        document.getElementById('bookingDrawer').classList.add('active');

        document.body.style.overflow = 'hidden';
    }

    function closeBookingDrawer() {
        document.getElementById('bookingDrawerOverlay').classList.remove('active');
        document.getElementById('bookingDrawer').classList.remove('active');
        document.body.style.overflow = '';
    }

    function sortFlights(criteria) {
        document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
        event.target.classList.add('active');

        // Simple visual sorting simulation for wowing effect
        const grid = document.querySelector('.flights-grid');
        const cards = Array.from(grid.querySelectorAll('.flight-card'));

        if (criteria === 'cheapest') {
            cards.sort((a, b) => {
                const pA = parseFloat(a.querySelector('.flight-price-amount').innerText.replace('$', ''));
                const pB = parseFloat(b.querySelector('.flight-price-amount').innerText.replace('$', ''));
                return pA - pB;
            });
        } else if (criteria === 'fastest') {
            cards.sort((a, b) => {
                const dA = parseFloat(a.querySelector('.timeline-duration').innerText.replace('h', '').replace('m', ''));
                const dB = parseFloat(b.querySelector('.timeline-duration').innerText.replace('h', '').replace('m', ''));
                return dA - dB;
            });
        }

        grid.innerHTML = '';
        cards.forEach(c => grid.appendChild(c));
    }

    document.getElementById('flightCheckoutForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;

        // Premium secure simulated checkout flow to ensure local environment bookings succeed instantly
        btn.innerHTML = '<i class="fa-solid fa-shield-halved fa-spin" style="margin-right: 8px;"></i> Securing Connection...';

        setTimeout(() => {
            const total = basePricePerTraveler * numTravelers;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 8px;"></i> Authorizing $' + total.toLocaleString() + '...';

            setTimeout(() => {
                btn.style.background = '#10B981';
                btn.style.borderColor = '#10B981';
                btn.innerHTML = '<i class="fa-solid fa-circle-check fa-bounce" style="margin-right: 8px;"></i> Payment Approved! Issuing Tickets...';

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'razorpay_payment_id';
                hiddenInput.value = 'pay_mock_' + Math.random().toString(36).substring(2, 10).toUpperCase();
                form.appendChild(hiddenInput);

                setTimeout(() => {
                    form.submit();
                }, 800);
            }, 1000);
        }, 800);
    });
</script>

</body>
</html>
