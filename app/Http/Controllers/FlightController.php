<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BoardingPassMail;

class FlightController extends Controller
{
    /**
     * Parse and search for flights matching departure and destination
     */
    public function search(Request $request)
    {
        $request->validate([
            'departure' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
            'travelers' => 'required|integer|min:1|max:10',
        ]);

        $depInput = trim($request->departure);
        $destInput = trim($request->destination);

        // Standardize airport codes helper
        $airports = [
            'new york' => ['name' => 'New York', 'code' => 'JFK'],
            'jfk' => ['name' => 'New York', 'code' => 'JFK'],
            'paris' => ['name' => 'Paris', 'code' => 'CDG'],
            'cdg' => ['name' => 'Paris', 'code' => 'CDG'],
            'london' => ['name' => 'London', 'code' => 'LHR'],
            'lhr' => ['name' => 'London', 'code' => 'LHR'],
            'bali' => ['name' => 'Bali', 'code' => 'DPS'],
            'dps' => ['name' => 'Bali', 'code' => 'DPS'],
            'tokyo' => ['name' => 'Tokyo', 'code' => 'NRT'],
            'nrt' => ['name' => 'Tokyo', 'code' => 'NRT'],
            'swiss' => ['name' => 'Zurich', 'code' => 'ZRH'],
            'zurich' => ['name' => 'Zurich', 'code' => 'ZRH'],
            'kyoto' => ['name' => 'Osaka/Kyoto', 'code' => 'KIX'],
            'kix' => ['name' => 'Osaka/Kyoto', 'code' => 'KIX'],
            'cape town' => ['name' => 'Cape Town', 'code' => 'CPT'],
            'cpt' => ['name' => 'Cape Town', 'code' => 'CPT'],
        ];

        // Resolve departure
        $depKey = strtolower($depInput);
        $depCity = $depInput;
        $depCode = 'DEP';
        foreach ($airports as $key => $info) {
            if (str_contains($depKey, $key)) {
                $depCity = $info['name'];
                $depCode = $info['code'];
                break;
            }
        }

        // Resolve destination
        $destKey = strtolower($destInput);
        $destCity = $destInput;
        $destCode = 'DST';
        foreach ($airports as $key => $info) {
            if (str_contains($destKey, $key)) {
                $destCity = $info['name'];
                $destCode = $info['code'];
                break;
            }
        }

        // Generate dynamic mock flights
        $departureDate = $request->departure_date;
        $returnDate = $request->return_date;
        $travelers = (int)$request->travelers;

        $flights = [
            [
                'airline' => 'Air France',
                'flight_number' => 'AF-' . rand(100, 999),
                'price' => 650,
                'departure_time' => '08:30 AM',
                'arrival_time' => '09:45 PM',
                'duration' => '7h 15m',
                'type' => 'Direct',
                'stops' => 'Non-stop',
                'class' => 'Economy',
                'carbon' => '-12% CO2',
                'logo' => 'fa-plane',
            ],
            [
                'airline' => 'Delta Air Lines',
                'flight_number' => 'DL-' . rand(100, 999),
                'price' => 520,
                'departure_time' => '11:15 AM',
                'arrival_time' => '01:30 AM',
                'duration' => '9h 15m',
                'type' => '1 Stop',
                'stops' => '1 Stop (BOS)',
                'class' => 'Economy',
                'carbon' => 'Average CO2',
                'logo' => 'fa-plane-up',
            ],
            [
                'airline' => 'Lufthansa',
                'flight_number' => 'LH-' . rand(100, 999),
                'price' => 580,
                'departure_time' => '03:45 PM',
                'arrival_time' => '07:10 AM',
                'duration' => '10h 25m',
                'type' => '1 Stop',
                'stops' => '1 Stop (FRA)',
                'class' => 'Economy',
                'carbon' => '-5% CO2',
                'logo' => 'fa-plane-departure',
            ],
            [
                'airline' => 'United Airlines',
                'flight_number' => 'UA-' . rand(100, 999),
                'price' => 490,
                'departure_time' => '06:15 AM',
                'arrival_time' => '02:40 PM',
                'duration' => '8h 25m',
                'type' => 'Direct',
                'stops' => 'Non-stop',
                'class' => 'Economy',
                'carbon' => '-8% CO2',
                'logo' => 'fa-plane',
            ],
            [
                'airline' => 'Swiss International',
                'flight_number' => 'LX-' . rand(100, 999),
                'price' => 610,
                'departure_time' => '01:10 PM',
                'arrival_time' => '10:55 PM',
                'duration' => '9h 45m',
                'type' => '1 Stop',
                'stops' => '1 Stop (ZRH)',
                'class' => 'Economy',
                'carbon' => '-14% CO2',
                'logo' => 'fa-plane-departure',
            ],
            [
                'airline' => 'Emirates',
                'flight_number' => 'EK-' . rand(100, 999),
                'price' => 850,
                'departure_time' => '10:15 PM',
                'arrival_time' => '09:35 AM',
                'duration' => '11h 20m',
                'type' => '1 Stop',
                'stops' => '1 Stop (DXB)',
                'class' => 'Economy',
                'carbon' => 'Average CO2',
                'logo' => 'fa-plane-up',
            ],
            [
                'airline' => 'British Airways',
                'flight_number' => 'BA-' . rand(100, 999),
                'price' => 590,
                'departure_time' => '09:40 AM',
                'arrival_time' => '07:50 PM',
                'duration' => '10h 10m',
                'type' => '1 Stop',
                'stops' => '1 Stop (LHR)',
                'class' => 'Economy',
                'carbon' => '-3% CO2',
                'logo' => 'fa-plane-departure',
            ],
            [
                'airline' => 'Singapore Airlines',
                'flight_number' => 'SQ-' . rand(100, 999),
                'price' => 880,
                'departure_time' => '07:20 PM',
                'arrival_time' => '07:15 AM',
                'duration' => '11h 55m',
                'type' => '1 Stop',
                'stops' => '1 Stop (SIN)',
                'class' => 'Economy',
                'carbon' => '-10% CO2',
                'logo' => 'fa-plane',
            ]
        ];

        // ── FLIGHT PRICE PREDICTION API / LOCAL SIMULATOR INTEGRATION ──
        $daysToDeparture = max(1, ceil((strtotime($departureDate) - time()) / 86400));

        // Base price determined by destination city distances
        $basePrices = [
            'Paris' => 550,
            'London' => 500,
            'Bali' => 450,
            'Tokyo' => 700,
            'Zurich' => 600,
            'Osaka' => 650,
            'Cape Town' => 750,
            'New York' => 400,
        ];
        $destBase = $basePrices[$destCity] ?? 500;

        foreach ($flights as &$flight) {
            $apiPrice = null;
            
            // Try fetching from the Heroku Flight Price Prediction API
            try {
                $response = \Illuminate\Support\Facades\Http::timeout(1.2)->post('https://flight-price-prediction-api.herokuapp.com/predict', [
                    'airline' => $flight['airline'],
                    'source' => $depCity,
                    'destination' => $destCity,
                    'days_left' => $daysToDeparture,
                    'class' => $flight['class'],
                    'stops' => $flight['stops'],
                ]);
                
                if ($response->successful()) {
                    $resData = $response->json();
                    $apiPrice = $resData['price'] ?? $resData['predicted_price'] ?? null;
                }
            } catch (\Exception $e) {
                // Fail silently and proceed to offline logic fallback
            }

            if ($apiPrice) {
                $flight['price'] = round($apiPrice);
            } else {
                // Offline Local Pricing Regression Model coefficient fallback
                $airlineMultiplier = 1.0;
                if ($flight['airline'] === 'Air France' || $flight['airline'] === 'Swiss International') {
                    $airlineMultiplier = 1.15;
                } elseif ($flight['airline'] === 'Lufthansa' || $flight['airline'] === 'British Airways') {
                    $airlineMultiplier = 1.10;
                } elseif ($flight['airline'] === 'Emirates' || $flight['airline'] === 'Singapore Airlines') {
                    $airlineMultiplier = 1.25; // Premium service
                } elseif ($flight['airline'] === 'United Airlines') {
                    $airlineMultiplier = 0.95; // Budget-friendly
                }

                $stopsMultiplier = $flight['type'] === 'Direct' ? 1.12 : 1.0;

                // Booking window days remaining penalty curves
                $daysFactor = 1.0;
                if ($daysToDeparture >= 30) {
                    $daysFactor = 0.88; // Advance booking discount
                } elseif ($daysToDeparture >= 15) {
                    $daysFactor = 1.0;  // Standard pricing zone
                } elseif ($daysToDeparture >= 8) {
                    $daysFactor = 1.0 + (15 - $daysToDeparture) * 0.04; // Moderate daily increase
                } else {
                    $daysFactor = 1.28 + (8 - $daysToDeparture) * 0.12;  // Extreme late booking pricing spikes
                }

                $predictedPrice = $destBase * $airlineMultiplier * $stopsMultiplier * $daysFactor;
                $flight['price'] = max(150, round($predictedPrice));
            }
        }
        unset($flight);

        $companions = auth()->check() ? auth()->user()->companions()->orderBy('name', 'asc')->get() : collect();
        $user = auth()->user();

        return view('flights.results', compact(
            'flights',
            'depCity',
            'depCode',
            'destCity',
            'destCode',
            'departureDate',
            'returnDate',
            'travelers',
            'companions',
            'user'
        ));
    }

    /**
     * Book mock flight and integrate with core bookings
     */
    public function book(Request $request)
    {
        $request->validate([
            'airline' => 'required|string',
            'flight_number' => 'required|string',
            'departure_city' => 'required|string',
            'destination_city' => 'required|string',
            'departure_code' => 'required|string',
            'destination_code' => 'required|string',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date',
            'price' => 'required|numeric',
            'travelers' => 'required|integer',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
        ]);

        // Find or fallback to matching destination
        $destQuery = Destination::query();
        $dest = $destQuery->where('name', 'like', "%{$request->destination_city}%")
                          ->orWhere('location', 'like', "%{$request->destination_city}%")
                          ->first();

        if (!$dest) {
            // Fallback to first available or create mock
            $dest = Destination::first() ?: Destination::create([
                'name' => $request->destination_city,
                'location' => 'International',
                'description' => 'A wonderful flight destination.',
                'min_budget' => 500,
                'max_budget' => 3000,
                'best_months' => [1,2,3,4,5,6,7,8,9,10,11,12],
                'image_url' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=800&q=80',
            ]);
        }

        $totalPrice = $request->price * $request->travelers;

        $booking = Booking::create([
            'destination_id' => $dest->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'start_date' => $request->departure_date,
            'end_date' => $request->return_date ?: $request->departure_date,
            'num_travelers' => $request->travelers,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        $flightData = [
            'airline' => $request->airline,
            'flight_number' => $request->flight_number,
            'departure_city' => $request->departure_city,
            'departure_code' => $request->departure_code,
            'destination_city' => $request->destination_city,
            'destination_code' => $request->destination_code,
            'price' => $request->price,
        ];

        // Save session meta
        session()->put('flight_' . $booking->booking_reference, $flightData);

        // Auto-send boarding pass email
        try {
            Mail::to($booking->customer_email)->send(new BoardingPassMail($booking, $flightData));
        } catch (\Exception $e) {
            logger()->error('Failed to send auto flight boarding pass email: ' . $e->getMessage());
        }

        return redirect()->route('bookings.confirmation', $booking->booking_reference)
                         ->with('success', 'Your flight was booked successfully!');
    }

    /**
     * Return autocomplete suggestions dynamically based on query string search from a global airports database
     */
    public function suggest(Request $request)
    {
        $query = strtolower(trim($request->query('query', '')));

        if (empty($query)) {
            return response()->json([]);
        }

        $suggestions = [];

        // 1. Search our database destinations first
        $dbDestinations = Destination::where('name', 'like', "%{$query}%")
                                      ->orWhere('location', 'like', "%{$query}%")
                                      ->get();
        
        foreach ($dbDestinations as $dest) {
            $suggestions[] = $dest->name . ' (DST)';
        }

        // 2. Fetch/Load global airports database (containing virtually all global commercial airports!)
        $path = storage_path('app/airports.json');
        $airports = [];

        if (file_exists($path)) {
            $airports = json_decode(file_get_contents($path), true) ?: [];
        } else {
            // Attempt keyless dynamic fetch from master open dataset
            if (!is_dir(storage_path('app'))) {
                mkdir(storage_path('app'), 0755, true);
            }
            $jsonContent = @file_get_contents('https://raw.githubusercontent.com/mwgg/Airports/master/airports.json');
            if ($jsonContent) {
                file_put_contents($path, $jsonContent);
                $airports = json_decode($jsonContent, true) ?: [];
            }
        }

        // 3. Match inputs against the global dataset of all airports in the world!
        if (!empty($airports)) {
            $count = 0;
            foreach ($airports as $code => $ap) {
                $iata = strtolower($ap['iata'] ?? '');
                $name = strtolower($ap['name'] ?? '');
                $city = strtolower($ap['city'] ?? '');
                $country = strtolower($ap['country'] ?? '');

                if ($iata === $query || 
                    str_contains($iata, $query) || 
                    str_contains($name, $query) || 
                    str_contains($city, $query) || 
                    str_contains($country, $query)) {
                    
                    if (!empty($ap['iata']) && !empty($ap['city'])) {
                        $label = $ap['city'] . ' (' . strtoupper($ap['iata']) . ') - ' . $ap['name'];
                        if (!in_array($label, $suggestions)) {
                            $suggestions[] = $label;
                            $count++;
                        }
                    }
                }
                
                // Limit to 15 dynamic global options to keep datalist highly responsive
                if ($count >= 15) {
                    break;
                }
            }
        }

        // Fallback static airports if offline and airports.json is not downloaded yet
        if (empty($suggestions)) {
            $fallbacks = [
                ['name' => 'New York (JFK)', 'city' => 'new york', 'code' => 'jfk'],
                ['name' => 'Paris Charles de Gaulle (CDG)', 'city' => 'paris', 'code' => 'cdg'],
                ['name' => 'London Heathrow (LHR)', 'city' => 'london', 'code' => 'lhr'],
                ['name' => 'Bali Ngurah Rai (DPS)', 'city' => 'bali', 'code' => 'dps'],
                ['name' => 'Tokyo Narita (NRT)', 'city' => 'tokyo', 'code' => 'nrt'],
            ];
            foreach ($fallbacks as $ap) {
                if (str_contains(strtolower($ap['name']), $query) || str_contains(strtolower($ap['city']), $query)) {
                    $suggestions[] = $ap['name'];
                }
            }
        }

        return response()->json(array_values(array_unique(array_slice($suggestions, 0, 10))));
    }
}
