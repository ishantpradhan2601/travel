<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelScape – Personalized Destination Finder</title>
    <meta name="description" content="Find your perfect destination based on your budget, travel dates, and preferred activities. AI-powered personalized travel recommendations.">
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            <li><a href="#" class="nav-cta"><i class="fa-solid fa-user"></i> Sign In</a></li>
        </ul>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
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

        <!-- Steps indicator -->
        <div class="steps-row">
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

        <form action="{{ route('recommend') }}" method="POST" id="searchForm">
            @csrf
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
    </div>
</div>

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
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').min = today;
    document.getElementById('start_date').addEventListener('change', function () {
        document.getElementById('end_date').min = this.value;
    });

    document.getElementById('searchForm').addEventListener('submit', function () {
        const btn = document.getElementById('searchBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Finding your matches…';
        btn.disabled = true;
    });
</script>

</body>
</html>
