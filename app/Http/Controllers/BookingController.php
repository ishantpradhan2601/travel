<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Store new travel booking reservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'num_travelers' => 'required|integer|min:1|max:20',
        ]);

        $destination = Destination::findOrFail($request->destination_id);
        $totalPrice = $destination->min_budget * $request->num_travelers;

        $booking = Booking::create([
            'destination_id' => $request->destination_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'num_travelers' => $request->num_travelers,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        return redirect()->route('bookings.confirmation', $booking->booking_reference)
                         ->with('success', 'Your reservation was processed successfully!');
    }

    /**
     * Show booking ticket confirmation
     */
    public function show($reference)
    {
        $booking = Booking::with(['destination', 'hotel'])->where('booking_reference', $reference)->firstOrFail();
        return view('bookings.confirmation', compact('booking'));
    }

    /**
     * List all reservations
     */
    public function index()
    {
        $bookings = Booking::with(['destination', 'hotel'])->latest()->get();
        
        $latestBooking = $bookings->first();
        if ($latestBooking && $latestBooking->destination_id) {
            // Recommend hotels in the same destination, excluding any hotel they already booked
            $bookedHotelId = $latestBooking->hotel_id;
            $recommendedHotels = Hotel::where('destination_id', $latestBooking->destination_id)
                ->when($bookedHotelId, function($q) use ($bookedHotelId) {
                    $q->where('id', '!=', $bookedHotelId);
                })
                ->limit(3)
                ->get();
                
            // If we find less than 3, fill with top-rated hotels globally
            if ($recommendedHotels->count() < 3) {
                $additional = Hotel::whereNotIn('id', $recommendedHotels->pluck('id'))
                    ->when($bookedHotelId, function($q) use ($bookedHotelId) {
                        $q->where('id', '!=', $bookedHotelId);
                    })
                    ->orderBy('rating', 'desc')
                    ->limit(3 - $recommendedHotels->count())
                    ->get();
                $recommendedHotels = $recommendedHotels->concat($additional);
            }
            $recommendationReason = "Based on your upcoming trip to " . ($latestBooking->destination->name ?? 'your destination');
        } else {
            // No bookings yet, recommend top-rated worldwide stays
            $recommendedHotels = Hotel::orderBy('rating', 'desc')->limit(3)->get();
            $recommendationReason = "Recommended Premium Stays Worldwide";
        }

        return view('bookings.index', compact('bookings', 'recommendedHotels', 'recommendationReason'));
    }
}
