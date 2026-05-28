<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Cancelled</title>
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
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        
        .header {
            background: linear-gradient(135deg, #ef4444, #f87171);
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

        .ticket-body {
            padding: 32px;
        }
        
        .cancellation-alert {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            padding: 16px 20px;
            color: #b91c1c;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
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

        .refund-box {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            display: table;
            width: 100%;
            box-sizing: border-box;
        }
        .refund-col-left {
            display: table-cell;
            text-align: left;
            vertical-align: middle;
        }
        .refund-col-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            font-size: 12px;
            color: #6b7280;
        }
        .refund-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
        }
        .refund-val {
            font-size: 20px;
            font-weight: 800;
            color: #ef4444;
        }

        .footer {
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
        }
        .footer a {
            color: #ef4444;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

@php
    $flight = session('flight_' . $booking->booking_reference);
    $hotel = $booking->hotel;
    
    if ($hotel) {
        $product = 'Hotel stay reservation for ' . $hotel->name;
    } elseif ($flight) {
        $product = 'Flight ' . $flight['flight_number'] . ' (' . $flight['departure_code'] . ' to ' . $flight['destination_code'] . ')';
    } else {
        $product = 'Travel package to ' . $booking->destination->name;
    }
@endphp

<div class="container">
    <!-- Header banner -->
    <div class="header">
        <div class="header-title">BOOKING CANCELLATION NOTICE</div>
        <div class="header-ref">REF: {{ $booking->booking_reference }}</div>
    </div>

    <!-- Body contents -->
    <div class="ticket-body">
        <div class="cancellation-alert">
            <strong>Your travel booking has been cancelled.</strong> We have initiated a full refund of your payment to the original credit/debit card used during checkout. Please allow 5-10 business days for the funds to reflect in your account.
        </div>

        <div class="grid">
            <div class="grid-row">
                <div class="grid-cell">
                    <div class="label">Customer Name</div>
                    <div class="value">{{ $booking->customer_name }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">Email Address</div>
                    <div class="value" style="font-size:12px; word-break:break-all;">{{ $booking->customer_email }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">Booking Status</div>
                    <div class="value" style="color: #ef4444;">✔ Cancelled</div>
                </div>
            </div>
            <div class="grid-row" style="height:12px;"></div>
            <div class="grid-row">
                <div class="grid-cell">
                    <div class="label">Product Details</div>
                    <div class="value" style="font-size: 13px;">{{ $product }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">Start Date</div>
                    <div class="value">{{ date('d M, Y', strtotime($booking->start_date)) }}</div>
                </div>
                <div class="grid-cell">
                    <div class="label">Total Travelers</div>
                    <div class="value">{{ $booking->num_travelers }} {{ $hotel ? 'Guest(s)' : 'Person(s)' }}</div>
                </div>
            </div>
        </div>

        <div class="perforation"></div>

        <!-- Pricing details -->
        <div class="refund-box">
            <div class="refund-col-left">
                <div class="refund-label">Refund Amount</div>
                <div class="refund-val">${{ number_format($booking->total_price) }}</div>
            </div>
            <div class="refund-col-right">
                Refund Method: Visa ending in 4242
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2026 <strong>TravelScape</strong>. A personalized travel recommendation system.</p>
    <p>If you have any questions or did not authorize this request, please contact our <a href="mailto:support@travelscape.com">Support Team</a>.</p>
</div>

</body>
</html>
