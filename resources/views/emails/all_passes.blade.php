<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Your Boarding Passes</title>
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
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
            padding: 32px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 24px;
            margin-bottom: 28px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin: 0 0 8px 0;
        }
        .header p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .booking-card {
            background-color: #f9fafb;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            margin-bottom: 20px;
            overflow: hidden;
            display: table;
            width: 100%;
            border-collapse: separate;
        }
        
        .card-header {
            padding: 14px 20px;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: block;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .title-row {
            margin-bottom: 12px;
        }
        .title-row h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            color: #111827;
            display: inline-block;
        }
        .ref-badge {
            display: inline-block;
            background-color: #e5e7eb;
            color: #374151;
            font-family: monospace;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 8px;
            vertical-align: middle;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 6px 0;
            font-size: 13px;
            color: #4b5563;
        }
        .details-table td.lbl {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            width: 30%;
        }
        .details-table td.val {
            font-weight: 700;
            color: #111827;
        }

        .card-footer {
            background-color: #f3f4f6;
            padding: 12px 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
        }
        .total-price {
            font-weight: 800;
            color: #ff5a30;
            float: right;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 32px;
        }
        .footer a {
            color: #ff5a30;
            text-decoration: none;
            font-weight: 600;
        }
        
        .btn-view-all {
            display: block;
            background-color: #ff5a30;
            color: #ffffff !important;
            padding: 14px 28px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 15px;
            text-decoration: none;
            text-align: center;
            margin: 28px auto 0 auto;
            max-width: 260px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Your TravelScape Boarding Passes</h1>
        <p>Hello, {{ $recipientName }}! Here are all the travel passes and stay reservations currently active on your account.</p>
    </div>

    @foreach($bookings as $booking)
        @php
            $flight = session('flight_' . $booking->booking_reference);
            $hotel = $booking->hotel;
            
            // Choose card headers and background gradients
            if ($hotel) {
                $bg = 'background: linear-gradient(135deg, #FF5A30, #ff8a65);';
                $typeLabel = 'HOTEL STAY RESERVATION';
                $title = $hotel->name;
                $location = $hotel->location;
            } elseif ($flight) {
                $bg = 'background: linear-gradient(135deg, #3b82f6, #56a8f5);';
                $typeLabel = 'FLIGHT PASS / BOARDING';
                $title = $flight['departure_code'] . ' ➔ ' . $flight['destination_code'];
                $location = $flight['airline'] . ' · Flight ' . $flight['flight_number'];
            } else {
                $bg = 'background: linear-gradient(135deg, #10b981, #34d399);';
                $typeLabel = 'BOARDING PASS / RESERVATION';
                $title = $booking->destination->name;
                $location = $booking->destination->location;
            }
        @endphp
        
        <div class="booking-card">
            <div class="card-header" style="{{ $bg }}">
                {{ $typeLabel }}
            </div>
            <div class="card-body">
                <div class="title-row">
                    <h3>{{ $title }}</h3>
                    <span class="ref-badge">REF: {{ $booking->booking_reference }}</span>
                    <div style="font-size: 12px; color: #6b7280; margin-top: 4px;">📍 {{ $location }}</div>
                </div>

                <table class="details-table">
                    <tr>
                        <td class="lbl">Passenger / Guest</td>
                        <td class="val">{{ $booking->customer_name }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">{{ $hotel ? 'Check-In' : 'Departure Date' }}</td>
                        <td class="val">{{ date('d M, Y', strtotime($booking->start_date)) }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">{{ $hotel ? 'Check-Out' : 'Return / Route' }}</td>
                        <td class="val">
                            {{ $hotel ? date('d M, Y', strtotime($booking->end_date)) : ($flight ? $flight['departure_city'] . ' to ' . $flight['destination_city'] : date('d M, Y', strtotime($booking->end_date))) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="lbl">Travelers</td>
                        <td class="val">{{ $booking->num_travelers }} {{ $hotel ? 'Guest(s)' : 'Person(s)' }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <strong>Booking Status:</strong> <span style="color: #10b981; font-weight:700;">✔ {{ ucfirst($booking->status) }}</span>
                <span class="total-price">Total Paid: ${{ number_format($booking->total_price) }}</span>
            </div>
        </div>
    @endforeach

    <div style="text-align: center;">
        <a href="{{ route('bookings.index') }}" class="btn-view-all">
            Manage All Bookings Online
        </a>
    </div>
</div>

<div class="footer">
    <p>&copy; 2026 <strong>TravelScape</strong>. A personalized travel recommendation system.</p>
    <p>Please present individual boarding barcodes when checking in.</p>
</div>

</body>
</html>
