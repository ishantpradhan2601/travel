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
                        <th>Destination / Stay</th>
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
                                    <img src="{{ $booking->hotel ? $booking->hotel->image_url : $booking->destination->image_url }}" alt="{{ $booking->hotel ? $booking->hotel->name : $booking->destination->name }}" class="dest-meta-img" onerror="{{ $booking->hotel ? 'handleHotelImgError(this)' : 'handleImgError(this)' }}">
                                    <div>
                                        <div class="dest-meta-title">
                                            @if($booking->hotel)
                                                <i class="fa-solid {{ $booking->hotel->type == 'hotel' ? 'fa-hotel' : 'fa-house-chimney' }}" style="color:var(--primary); font-size:0.8rem; margin-right:0.25rem;"></i>
                                            @endif
                                            {{ $booking->hotel ? $booking->hotel->name : $booking->destination->name }}
                                        </div>
                                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ $booking->hotel ? $booking->hotel->location : $booking->destination->location }}</div>
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
