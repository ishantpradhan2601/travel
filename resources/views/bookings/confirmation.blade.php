<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed – {{ $booking->booking_reference }}</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .ticket-page {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 1.5rem;
        }
        /* Ticket Pass Boarding Layout */
        .ticket-board {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }
        .ticket-header {
            background: linear-gradient(135deg, var(--primary), #ff8a65);
            padding: 1.5rem 2rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ticket-header-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
            font-weight: 800;
        }
        .ticket-header-ref {
            background: rgba(255,255,255,0.2);
            padding: 0.35rem 0.85rem;
            border-radius: 100px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        
        .ticket-hero {
            position: relative;
            height: 180px;
            overflow: hidden;
        }
        .ticket-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .ticket-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.6) 100%);
        }
        .ticket-hero-info {
            position: absolute;
            bottom: 1.5rem;
            left: 2rem;
            color: white;
        }
        .ticket-hero-info h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }
        .ticket-hero-info p {
            font-size: 0.9rem;
            opacity: 0.85;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .ticket-body {
            padding: 2rem;
            position: relative;
        }
        
        /* Dashboard visual columns */
        .ticket-info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .ticket-info-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }
        .ticket-info-group label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .ticket-info-group span {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
        }

        /* Perforated divider visual */
        .ticket-perforation {
            height: 1px;
            border-top: 2px dashed var(--border);
            margin: 1.5rem 0;
            position: relative;
        }
        .ticket-perforation::before, .ticket-perforation::after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background: var(--bg);
            border-radius: 50%;
            border: 1px solid var(--border);
        }
        .ticket-perforation::before { left: -31px; }
        .ticket-perforation::after { right: -31px; }

        .ticket-price-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg);
            padding: 1.25rem 1.75rem;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }
        .ticket-price-info {
            display: flex;
            flex-direction: column;
        }
        .ticket-price-info label {
            font-size: 0.72rem;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
        }
        .ticket-price-info span {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* Simulated Barcode */
        .ticket-barcode-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            margin-top: 2rem;
        }
        .ticket-barcode {
            width: 100%;
            max-width: 320px;
            height: 50px;
            background: repeating-linear-gradient(90deg, 
                #111, #111 2px, 
                transparent 2px, transparent 6px,
                #111 6px, #111 10px,
                transparent 10px, transparent 12px,
                #111 12px, #111 14px,
                transparent 14px, transparent 18px
            );
        }
        .ticket-barcode-num {
            font-size: 0.72rem;
            font-family: monospace;
            color: var(--text-muted);
            letter-spacing: 0.2em;
        }

        .ticket-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 2.5rem;
        }
        @media print {
            .navbar, .ticket-actions, .footer { display: none !important; }
            body { background: white; }
            .ticket-page { margin: 0; padding: 0; }
            .ticket-board { box-shadow: none; border: none; }
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
            <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            <li><a href="{{ route('home') }}">Find Destinations</a></li>
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

@php
    $flight = session('flight_' . $booking->booking_reference);
    $hotel = $booking->hotel;
@endphp

<!-- MAIN CONTENT -->
<div class="ticket-page">
    
    @if(session('success'))
        <div style="background:#e6faf7;border:1px solid #a7f3d0;border-radius:10px;padding:1rem 1.5rem;margin-bottom:1.5rem;color:#047857;font-size:0.9rem;display:flex;align-items:center;gap:0.6rem;" class="fade-in">
            <i class="fa-solid fa-circle-check" style="font-size:1.1rem"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="ticket-board fade-in">
        <!-- Header -->
        <div class="ticket-header" style="{{ $hotel ? 'background: linear-gradient(135deg, var(--primary), #ff8a65);' : ($flight ? 'background: linear-gradient(135deg, var(--secondary), #56a8f5);' : '') }}">
            <div class="ticket-header-logo">
                @if($hotel)
                    <i class="fa-solid {{ $hotel->type == 'hotel' ? 'fa-hotel' : 'fa-house-chimney' }}"></i> {{ strtoupper($hotel->type) }} RESERVATION / STAY
                @elseif($flight)
                    <i class="fa-solid fa-plane"></i> FLIGHT PASS / BOARDING
                @else
                    <i class="fa-solid fa-plane"></i> BOARDING PASS / RES
                @endif
            </div>
            <div class="ticket-header-ref">
                REF: {{ $booking->booking_reference }}
            </div>
        </div>

        <!-- Banner Visual -->
        <div class="ticket-hero">
            <img src="{{ $hotel ? $hotel->image_url : $booking->destination->image_url }}" alt="{{ $hotel ? $hotel->name : $booking->destination->name }}" onerror="handleImgError(this)">
            <div class="ticket-hero-overlay"></div>
            <div class="ticket-hero-info">
                @if($hotel)
                    <h2>{{ $hotel->name }}</h2>
                    <p><i class="fa-solid fa-location-dot"></i> {{ $hotel->location }}</p>
                @elseif($flight)
                    <h2>{{ $flight['departure_code'] }} <i class="fa-solid fa-arrow-right-long" style="font-size:1.1rem;vertical-align:middle;margin:0 0.5rem"></i> {{ $flight['destination_code'] }}</h2>
                    <p><i class="fa-solid fa-plane-departure"></i> {{ $flight['airline'] }} · Flight {{ $flight['flight_number'] }}</p>
                @else
                    <h2>{{ $booking->destination->name }}</h2>
                    <p><i class="fa-solid fa-location-dot"></i> {{ $booking->destination->location }}</p>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div class="ticket-body">
            <div class="ticket-info-grid">
                <div class="ticket-info-group">
                    <label>{{ $hotel ? 'Lead Guest Name' : 'Passenger Name' }}</label>
                    <span>{{ $booking->customer_name }}</span>
                </div>
                <div class="ticket-info-group">
                    <label>Email Address</label>
                    <span style="font-size:0.85rem;word-break:break-all;">{{ $booking->customer_email }}</span>
                </div>
                <div class="ticket-info-group">
                    <label>Booking Status</label>
                    <span style="color:#00C9A7;"><i class="fa-solid fa-circle-check"></i> {{ ucfirst($booking->status) }}</span>
                </div>

                <div class="ticket-info-group">
                    <label>{{ $hotel ? 'Check-In Date' : 'Departure Date' }}</label>
                    <span>{{ date('d M, Y', strtotime($booking->start_date)) }}</span>
                </div>
                <div class="ticket-info-group">
                    <label>{{ $hotel ? 'Check-Out Date' : ($flight ? 'Route details' : 'Return Date') }}</label>
                    <span>{{ $hotel ? date('d M, Y', strtotime($booking->end_date)) : ($flight ? $flight['departure_city'] . ' to ' . $flight['destination_city'] : date('d M, Y', strtotime($booking->end_date))) }}</span>
                </div>
                <div class="ticket-info-group">
                    <label>{{ $hotel ? 'Total Guests' : 'Total Travelers' }}</label>
                    <span>{{ $booking->num_travelers }} {{ Str::plural($hotel ? 'Guest' : 'Person', $booking->num_travelers) }}</span>
                </div>
            </div>

            <!-- Perforation segment -->
            <div class="ticket-perforation"></div>

            <!-- Pricing Box -->
            <div class="ticket-price-box">
                <div class="ticket-price-info">
                    <label>{{ $hotel ? 'stay reservation cost' : 'Calculated Dynamic Cost' }}</label>
                    <span>${{ number_format($booking->total_price) }}</span>
                </div>
                <div style="font-size:0.8rem;color:var(--text-muted);text-align:right;">
                    @if($hotel)
                        @php
                            $nights = max(1, Carbon\Carbon::parse($booking->end_date)->diffInDays(Carbon\Carbon::parse($booking->start_date)));
                        @endphp
                        Stay rate: ${{ number_format($hotel->price_per_night) }} x {{ $nights }} night{{ $nights != 1 ? 's' : '' }}
                    @elseif($flight)
                        Base flight rate: ${{ number_format($flight['price']) }} x {{ $booking->num_travelers }} traveler(s)
                    @else
                        Base rate: ${{ number_format($booking->destination->min_budget) }} x {{ $booking->num_travelers }} traveler(s)
                    @endif
                </div>
            </div>

            <!-- Transaction Details Box -->
            <div style="margin-top:1.5rem; padding:1.25rem 1.75rem; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-sm);">
                <h4 style="margin: 0 0 1rem 0; font-size: 1rem; color: var(--text); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;"><i class="fa-solid fa-file-invoice-dollar"></i> Transaction Details</h4>
                <div class="ticket-info-grid" style="margin-bottom: 0; gap: 1rem;">
                    <div class="ticket-info-group">
                        <label>Transaction ID</label>
                        <span style="font-family: monospace;">TXN-{{ strtoupper(Str::random(8)) }}</span>
                    </div>
                    <div class="ticket-info-group">
                        <label>Payment Method</label>
                        <span><i class="fa-brands fa-cc-visa" style="color:#1434CB"></i> Visa ending in 4242</span>
                    </div>
                    <div class="ticket-info-group">
                        <label>Payment Date</label>
                        <span>{{ date('d M, Y H:i', strtotime($booking->created_at ?? now())) }}</span>
                    </div>
                </div>
            </div>

            <!-- Barcode -->
            <div class="ticket-barcode-wrap">
                <div class="ticket-barcode"></div>
                <span class="ticket-barcode-num">{{ $booking->booking_reference }}</span>
            </div>
        </div>
    </div>

    <!-- Ticket Actions -->
    <div class="ticket-actions fade-in-2">
        <button class="btn-outline" onclick="window.print()" style="padding:0.55rem 1.5rem;font-size:0.9rem">
            <i class="fa-solid fa-print"></i> Print Boarding Pass
        </button>
        <a href="{{ route('bookings.index') }}" class="back-btn" style="border-radius:100px;font-size:0.9rem;padding:0.55rem 1.5rem">
            <i class="fa-solid fa-list"></i> View All Bookings
        </a>
    </div>

</div>

<!-- FOOTER -->
<footer class="footer" style="margin-top:4rem">
    <p>
        &copy; 2026 <span>TravelScape</span>. A personalized travel recommendation system
        built with Laravel 12. All rights reserved.
    </p>
</footer>

</body>
</html>
