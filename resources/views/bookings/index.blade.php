<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Travel Bookings – TravelScape</title>
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .bookings-table-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-top: 1.5rem;
        }
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .bookings-table th {
            background: var(--bg);
            padding: 1rem 1.5rem;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }
        .bookings-table td {
            padding: 1.25rem 1.5rem;
            font-size: 0.9rem;
            color: var(--text);
            border-bottom: 1px solid var(--border);
        }
        .bookings-table tr:last-child td {
            border-bottom: none;
        }
        .bookings-table tr:hover td {
            background: #fafafb;
        }
        .dest-meta-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .dest-meta-img {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid var(--border);
        }
        .dest-meta-title {
            font-weight: 700;
            color: var(--text);
        }
        .ref-badge {
            background: var(--primary-light);
            color: var(--primary);
            font-family: monospace;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 100px;
            text-transform: uppercase;
        }
        .status-badge.confirmed {
            background: #e6faf7;
            color: #00C9A7;
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
            <li><a href="{{ route('bookings.index') }}" class="active">My Bookings</a></li>
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

@if(session('success'))
    <div class="page-content" style="padding-top: 1.5rem; padding-bottom: 0; max-width: 1200px; margin: 0 auto;">
        <div style="background:#e6faf7; border:1px solid #a7f3d0; border-radius:10px; padding:1rem 1.5rem; color:#047857; font-size:0.9rem; display:flex; align-items:center; gap:0.6rem; box-shadow: var(--shadow);" class="fade-in">
            <i class="fa-solid fa-circle-check" style="font-size:1.1rem"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

<!-- MINI HERO -->
<div style="background:linear-gradient(135deg,#1c1c2e,#FF5A30);padding:3rem 1.5rem 6rem;text-align:center;">
    <h1 style="color:white;font-size:2.2rem;font-weight:800;margin-bottom:0.5rem;">
        Your Travel Bookings
    </h1>
    <p style="color:rgba(255,255,255,0.85);font-size:1rem;">
        Keep track of all your reservations and active boarding passes
    </p>
</div>

<!-- RESULTS CONTENT -->
<div class="page-content" style="margin-top:-50px;">

    <!-- Action bar -->
    <div class="results-bar fade-in" style="margin-bottom: 0;">
        <div class="results-bar-info">
            <i class="fa-solid fa-plane-departure" style="color:#FF5A30;"></i>
            <span class="results-count">{{ $bookings->count() }} active trip{{ $bookings->count() != 1 ? 's' : '' }}</span>
        </div>
        <a href="{{ route('home') }}" class="back-btn">
            <i class="fa-solid fa-plus"></i> Book a New Trip
        </a>
    </div>

    @if($bookings->isEmpty())
        <!-- Empty State -->
        <div class="empty-state fade-in" style="margin-top:1.5rem;">
            <i class="fa-solid fa-ticket" style="color:#e5e7eb;"></i>
            <h2>No bookings found</h2>
            <p>You haven't made any travel reservations yet. Start matching now!</p>
            <a href="{{ route('home') }}" class="btn-outline">
                <i class="fa-solid fa-compass"></i> Find My Perfect Trip
            </a>
        </div>

    @else
        <!-- Table Visual -->
        <div class="bookings-table-card fade-in">
            <table class="bookings-table">
                <thead>
                    <tr>
                        <th>Destination</th>
                        <th>Reference</th>
                        <th>Traveler</th>
                        <th>Dates</th>
                        <th>Travelers</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>
                                <div class="dest-meta-cell">
                                    <img src="{{ $booking->destination->image_url }}" alt="{{ $booking->destination->name }}" class="dest-meta-img">
                                    <div>
                                        <div class="dest-meta-title">{{ $booking->destination->name }}</div>
                                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ $booking->destination->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="ref-badge">{{ $booking->booking_reference }}</span>
                            </td>
                            <td>
                                <div style="font-weight:600">{{ $booking->customer_name }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted)">{{ $booking->customer_email }}</div>
                            </td>
                            <td>
                                <div style="font-weight:600">{{ date('d M, Y', strtotime($booking->start_date)) }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted)">to {{ date('d M, Y', strtotime($booking->end_date)) }}</div>
                            </td>
                            <td>
                                <span style="font-weight:600">{{ $booking->num_travelers }} {{ Str::plural('pax', $booking->num_travelers) }}</span>
                            </td>
                            <td>
                                <span style="font-weight:800;color:var(--primary)">${{ number_format($booking->total_price) }}</span>
                            </td>
                            <td>
                                <span class="status-badge confirmed">
                                    <i class="fa-solid fa-circle-check"></i> {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('bookings.confirmation', $booking->booking_reference) }}" class="btn-book" style="padding:0.45rem 1rem;font-size:0.78rem;text-decoration:none;display:inline-block;">
                                    View Ticket
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

<!-- FOOTER -->
<footer class="footer">
    <p>
        &copy; 2026 <span>TravelScape</span>. A personalized travel recommendation system
        built with Laravel 12. All rights reserved.
    </p>
</footer>

</body>
</html>
