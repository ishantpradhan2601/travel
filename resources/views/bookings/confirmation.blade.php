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
            <li><a href="#" class="nav-cta"><i class="fa-solid fa-user"></i> Dashboard</a></li>
        </ul>
    </div>
</nav>

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
        <div class="ticket-header">
            <div class="ticket-header-logo">
                <i class="fa-solid fa-plane"></i> BOARDING PASS / RES
            </div>
            <div class="ticket-header-ref">
                REF: {{ $booking->booking_reference }}
            </div>
        </div>

        <!-- Banner Visual -->
        <div class="ticket-hero">
            <img src="{{ $booking->destination->image_url }}" alt="{{ $booking->destination->name }}">
            <div class="ticket-hero-overlay"></div>
            <div class="ticket-hero-info">
                <h2>{{ $booking->destination->name }}</h2>
                <p><i class="fa-solid fa-location-dot"></i> {{ $booking->destination->location }}</p>
            </div>
        </div>

        <!-- Body -->
        <div class="ticket-body">
            <div class="ticket-info-grid">
                <div class="ticket-info-group">
                    <label>Passenger Name</label>
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
                    <label>Departure Date</label>
                    <span>{{ date('d M, Y', strtotime($booking->start_date)) }}</span>
                </div>
                <div class="ticket-info-group">
                    <label>Return Date</label>
                    <span>{{ date('d M, Y', strtotime($booking->end_date)) }}</span>
                </div>
                <div class="ticket-info-group">
                    <label>Total Travelers</label>
                    <span>{{ $booking->num_travelers }} {{ Str::plural('Person', $booking->num_travelers) }}</span>
                </div>
            </div>

            <!-- Perforation segment -->
            <div class="ticket-perforation"></div>

            <!-- Pricing Box -->
            <div class="ticket-price-box">
                <div class="ticket-price-info">
                    <label>Calculated Dynamic Cost</label>
                    <span>${{ number_format($booking->total_price) }}</span>
                </div>
                <div style="font-size:0.8rem;color:var(--text-muted);text-align:right;">
                    Base rate: ${{ number_format($booking->destination->min_budget) }} x {{ $booking->num_travelers }} traveler(s)
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
