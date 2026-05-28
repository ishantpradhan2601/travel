<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Boarding Pass</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            color: #1f2937;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        /* Gradients based on Booking Type */
        .header {
            padding: 24px 32px;
            color: #ffffff;
            text-align: left;
        }
        .header-title {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.1em;
            margin: 0 0 6px 0;
            text-transform: uppercase;
        }
        .header-ref {
            font-size: 20px;
            font-weight: 800;
            margin: 0;
        }
        
        .hero-banner {
            background-color: #111827;
            color: #ffffff;
            padding: 24px 32px;
            text-align: left;
            position: relative;
        }
        .hero-banner h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 8px 0;
        }
        .hero-banner p {
            font-size: 14px;
            color: #9ca3af;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .ticket-body {
            padding: 32px;
        }

        .grid {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }
        .grid-row {
            display: table-row;
        }
        .grid-cell {
            display: table-cell;
            width: 33.333%;
            padding-bottom: 16px;
            vertical-align: top;
        }
        .label {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .value {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }

        .perforation {
            height: 1px;
            border-top: 2px dashed #e5e7eb;
            margin: 24px 0;
        }

        .price-box {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            display: table;
            width: 100%;
            box-sizing: border-box;
        }
        .price-col-left {
            display: table-cell;
            text-align: left;
            vertical-align: middle;
        }
        .price-col-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            font-size: 12px;
            color: #6b7280;
        }
        .price-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
        }
        .price-val {
            font-size: 20px;
            font-weight: 800;
            color: #ff5a30;
        }

        /* Simulated Barcode */
        .barcode-wrap {
            text-align: center;
            margin-top: 32px;
            background-color: #ffffff;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }
        .barcode {
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
        .barcode-num {
            font-size: 11px;
            font-family: monospace;
            color: #4b5563;
            letter-spacing: 0.25em;
            margin-top: 8px;
            display: block;
        }

        .footer {
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        .footer a {
            color: #ff5a30;
            text-decoration: none;
            font-weight: 600;
        }
        
        .btn-view {
            display: inline-block;
            background-color: #ff5a30;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            margin-top: 24px;
            text-align: center;
        }
    </style>
</head>
<body>

@php
    $flight = $flight ?? session('flight_' . $booking->booking_reference);
    $hotel = $booking->hotel;
    
    // Choose appropriate background gradients
    if ($hotel) {
        $gradient = 'background: linear-gradient(135deg, #FF5A30, #ff8a65);';
        $typeLabel = 'HOTEL STAY RESERVATION';
    } elseif ($flight) {
        $gradient = 'background: linear-gradient(135deg, #3b82f6, #56a8f5);';
        $typeLabel = 'FLIGHT PASS / BOARDING';
    } else {
        $gradient = 'background: linear-gradient(135deg, #10b981, #34d399);';
        $typeLabel = 'BOARDING PASS / RESERVATION';
    }
@endphp

<div class="container">
    <!-- Header banner -->
    <div class="header" style="{{ $gradient }}">
        <div class="header-title">{{ $typeLabel }}</div>
        <div class="header-ref">REF: {{ $booking->booking_reference }}</div>
    </div>

    <!-- Sub-hero segment -->
    <div class="hero-banner">
        @if($hotel)
            <h2>{{ $hotel->name }}</h2>
            <p>📍 {{ $hotel->location }}</p>
        @elseif($flight)
            <h2>{{ $flight['departure_code'] }} ➔ {{ $flight['destination_code'] }}</h2>
            <p>✈️ {{ $flight['airline'] }} · Flight {{ $flight['flight_number'] }}</p>
        @else
            <h2>{{ $booking->destination->name }}</h2>
            <p>📍 {{ $booking->destination->location }}</p>
        @endif
    </div>

    <!-- Body contents -->
    <div class="ticket-body">
        <div class="grid">
            <div class="grid-row">
                <div class="grid-cell">
                    <div class="label">{{ $hotel ? 'Lead Guest' : 'Passenger' }}</div>
                    <div class="value">{{ $booking->customer_name }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">Email Address</div>
                    <div class="value" style="font-size:12px; word-break:break-all;">{{ $booking->customer_email }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">Status</div>
                    <div class="value" style="color: #10b981;">✔ {{ ucfirst($booking->status) }}</div>
                </div>
            </div>
            <div class="grid-row" style="height:12px;"></div>
            <div class="grid-row">
                <div class="grid-cell">
                    <div class="label">{{ $hotel ? 'Check-In Date' : 'Departure Date' }}</div>
                    <div class="value">{{ date('d M, Y', strtotime($booking->start_date)) }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">{{ $hotel ? 'Check-Out Date' : ($flight ? 'Route' : 'Return Date') }}</div>
                    <div class="value">{{ $hotel ? date('d M, Y', strtotime($booking->end_date)) : ($flight ? $flight['departure_city'] . ' to ' . $flight['destination_city'] : date('d M, Y', strtotime($booking->end_date))) }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">{{ $hotel ? 'Total Guests' : 'Travelers' }}</div>
                    <div class="value">{{ $booking->num_travelers }} {{ $hotel ? 'Guest(s)' : 'Person(s)' }}</div>
                </div>
            </div>
        </div>

        <div class="perforation"></div>

        <!-- Pricing details -->
        <div class="price-box">
            <div class="price-col-left">
                <div class="price-label">{{ $hotel ? 'Stay Cost' : 'Calculated Price' }}</div>
                <div class="price-val">${{ number_format($booking->total_price) }}</div>
            </div>
            <div class="price-col-right">
                @if($hotel)
                    @php
                        $nights = max(1, Carbon\Carbon::parse($booking->end_date)->diffInDays(Carbon\Carbon::parse($booking->start_date)));
                    @endphp
                    Rate: ${{ number_format($hotel->price_per_night) }} x {{ $nights }} night(s)
                @elseif($flight)
                    Flight Rate: ${{ number_format($flight['price']) }} x {{ $booking->num_travelers }} pax
                @else
                    Rate: ${{ number_format($booking->destination->min_budget) }} x {{ $booking->num_travelers }} pax
                @endif
            </div>
        </div>

        <!-- Barcode -->
        <div class="barcode-wrap">
            <div class="barcode"></div>
            <span class="barcode-num">{{ $booking->booking_reference }}</span>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('bookings.confirmation', $booking->booking_reference) }}" class="btn-view">
                View Reservation Online
            </a>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2026 <strong>TravelScape</strong>. A personalized travel recommendation system.</p>
    <p>This is a automated travel document confirmation. Please present the barcode during check-in.</p>
</div>

</body>
</html>
