<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the hotels/Airbnbs with advanced filtering.
     */
    public function index(Request $request)
    {
        $query = Hotel::with('destination');

        // Filter by location / destination search
        if ($request->filled('location')) {
            $loc = $request->location;
            $query->where(function($q) use ($loc) {
                $q->where('location', 'like', "%{$loc}%")
                  ->orWhere('name', 'like', "%{$loc}%")
                  ->orWhereHas('destination', function($destQ) use ($loc) {
                      $destQ->where('name', 'like', "%{$loc}%")
                            ->orWhere('location', 'like', "%{$loc}%");
                  });
            });
        }

        // Filter by type (hotel / airbnb)
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Filter by price range
        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max);
        }
        if ($request->filled('price_min')) {
            $query->where('price_per_night', '>=', $request->price_min);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter by amenities
        if ($request->filled('amenities') && is_array($request->amenities)) {
            foreach ($request->amenities as $amenity) {
                $query->where('amenities', 'like', "%\"{$amenity}\"%");
            }
        }

        // Sort options
        $sortBy = $request->get('sort', 'recommended');
        if ($sortBy === 'price_low') {
            $query->orderBy('price_per_night', 'asc');
        } elseif ($sortBy === 'price_high') {
            $query->orderBy('price_per_night', 'desc');
        } elseif ($sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('rating', 'desc'); // recommended is high-rated first
        }

        $hotels = $query->get();
        $destinations = Destination::select('id', 'name', 'location')->get();

        // Get list of all unique amenities for display filter
        $allAmenities = [
            'Wifi', 'Pool', 'Spa', 'Restaurant', 'Air Conditioning', 
            'Free Parking', 'Kitchen', 'Gym', 'Bar', 'Free Breakfast', 
            'Hot Tub', 'Fireplace', 'Washing Machine', 'Balcony'
        ];

        return view('hotels.index', compact('hotels', 'destinations', 'allAmenities'));
    }

    /**
     * Show detailed view of a specific hotel/Airbnb.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load('destination');
        return view('hotels.show', compact('hotel'));
    }

    /**
     * Book a stay at the selected Hotel or Airbnb.
     */
    public function book(Request $request, Hotel $hotel)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'travelers' => 'required|integer|min:1|max:10',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        
        $nights = $end->diffInDays($start);
        if ($nights === 0) {
            $nights = 1; // Minimum 1 night charge
        }

        $totalPrice = $hotel->price_per_night * $nights;

        $booking = Booking::create([
            'destination_id' => $hotel->destination_id ?: (Destination::first()->id ?? 1),
            'hotel_id' => $hotel->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'num_travelers' => $request->travelers,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        return redirect()->route('bookings.confirmation', $booking->booking_reference)
                         ->with('success', 'Your Hotel stay has been successfully reserved!');
    }

    /**
     * REST API: Search and list properties
     */
    public function apiSearch(Request $request)
    {
        $query = Hotel::with('destination');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        $hotels = $query->get();

        return response()->json([
            'status' => 'success',
            'count' => $hotels->count(),
            'data' => $hotels
        ]);
    }

    /**
     * REST API: Fetch property details
     */
    public function apiDetail(Hotel $hotel)
    {
        $hotel->load('destination');
        return response()->json([
            'status' => 'success',
            'data' => $hotel
        ]);
    }
}
