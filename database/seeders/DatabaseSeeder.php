<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            'Adventure' => Activity::create(['name' => 'Adventure']),
            'Relaxation' => Activity::create(['name' => 'Relaxation']),
            'Culture' => Activity::create(['name' => 'Culture']),
            'Food' => Activity::create(['name' => 'Food']),
            'Nightlife' => Activity::create(['name' => 'Nightlife']),
            'Nature' => Activity::create(['name' => 'Nature']),
        ];

        $destinations = [
            [
                'name' => 'Bali',
                'location' => 'Indonesia',
                'description' => 'Tropical paradise with beautiful beaches and rich culture.',
                'min_budget' => 500,
                'max_budget' => 2000,
                'best_months' => [4, 5, 6, 7, 8, 9, 10],
                'activities' => ['Relaxation', 'Nature', 'Culture'],
                'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Swiss Alps',
                'location' => 'Switzerland',
                'description' => 'Stunning mountains, perfect for skiing and summer hiking.',
                'min_budget' => 1500,
                'max_budget' => 5000,
                'best_months' => [12, 1, 2, 3, 6, 7, 8],
                'activities' => ['Adventure', 'Nature'],
                'image_url' => 'https://images.unsplash.com/photo-1531310197839-ccf54634509e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Paris',
                'location' => 'France',
                'description' => 'The city of light, famous for art, fashion, and gastronomy.',
                'min_budget' => 1000,
                'max_budget' => 4000,
                'best_months' => [4, 5, 6, 9, 10],
                'activities' => ['Culture', 'Food', 'Nightlife'],
                'image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Kyoto',
                'location' => 'Japan',
                'description' => 'A city that preserves old Japan with temples and cherry gardens.',
                'min_budget' => 800,
                'max_budget' => 3000,
                'best_months' => [3, 4, 10, 11],
                'activities' => ['Culture', 'Relaxation', 'Nature'],
                'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Cape Town',
                'location' => 'South Africa',
                'description' => 'Stunning port city below the imposing Table Mountain.',
                'min_budget' => 700,
                'max_budget' => 2500,
                'best_months' => [11, 12, 1, 2, 3],
                'activities' => ['Nature', 'Food', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1580619305218-8423a7ef79b4?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'New York',
                'location' => 'United States',
                'description' => 'The Big Apple, featuring Broadway, Central Park, and nightlife.',
                'min_budget' => 1200,
                'max_budget' => 4500,
                'best_months' => [4, 5, 6, 9, 10, 11],
                'activities' => ['Culture', 'Nightlife', 'Food'],
                'image_url' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'London',
                'location' => 'United Kingdom',
                'description' => 'Rich royal heritage, iconic red buses, and vibrant theatre scene.',
                'min_budget' => 1100,
                'max_budget' => 4200,
                'best_months' => [5, 6, 7, 8, 9],
                'activities' => ['Culture', 'Nightlife', 'Food'],
                'image_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ca1ad?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Tokyo',
                'location' => 'Japan',
                'description' => 'Ultramodern skyscrapers, neon lights, and unmatched food markets.',
                'min_budget' => 900,
                'max_budget' => 3500,
                'best_months' => [3, 4, 5, 10, 11],
                'activities' => ['Food', 'Nightlife', 'Culture'],
                'image_url' => 'https://images.unsplash.com/photo-1540959733332-eab4deceeaf7?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Rome',
                'location' => 'Italy',
                'description' => 'An open-air museum of ancient ruins, coliseums, and fine pasta.',
                'min_budget' => 750,
                'max_budget' => 2800,
                'best_months' => [4, 5, 6, 9, 10],
                'activities' => ['Culture', 'Food', 'Relaxation'],
                'image_url' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Sydney',
                'location' => 'Australia',
                'description' => 'Beautiful Opera House, golden beaches, and warm coastal vibes.',
                'min_budget' => 1400,
                'max_budget' => 4800,
                'best_months' => [10, 11, 12, 1, 2, 3],
                'activities' => ['Nature', 'Relaxation', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Barcelona',
                'location' => 'Spain',
                'description' => 'Gothic quarters, Gaudi architecture, and delicious seaside tapas.',
                'min_budget' => 650,
                'max_budget' => 2600,
                'best_months' => [5, 6, 7, 9, 10],
                'activities' => ['Culture', 'Food', 'Nightlife'],
                'image_url' => 'https://images.unsplash.com/photo-1583422409516-2895a77efedd?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Dubai',
                'location' => 'United Arab Emirates',
                'description' => 'Luxury shopping, futuristic structures, and desert dune safaris.',
                'min_budget' => 1000,
                'max_budget' => 4500,
                'best_months' => [11, 12, 1, 2, 3],
                'activities' => ['Adventure', 'Nightlife', 'Relaxation'],
                'image_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Rio de Janeiro',
                'location' => 'Brazil',
                'description' => 'Bustling Copacabana beach, Christ the Redeemer, and lively samba beats.',
                'min_budget' => 800,
                'max_budget' => 2800,
                'best_months' => [12, 1, 2, 3, 4],
                'activities' => ['Nightlife', 'Nature', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Cairo',
                'location' => 'Egypt',
                'description' => 'The cradle of civilization, featuring Giza pyramids and Nile cruises.',
                'min_budget' => 400,
                'max_budget' => 1800,
                'best_months' => [10, 11, 12, 1, 2, 3],
                'activities' => ['Culture', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1503177119275-0aa32b31d468?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Amsterdam',
                'location' => 'Netherlands',
                'description' => 'Charming canal rings, cycling culture, and famous museum quarters.',
                'min_budget' => 850,
                'max_budget' => 3200,
                'best_months' => [4, 5, 6, 9, 10],
                'activities' => ['Culture', 'Nightlife', 'Relaxation'],
                'image_url' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Venice',
                'location' => 'Italy',
                'description' => 'Romantic gondola cruises, historic bridges, and floating palaces.',
                'min_budget' => 900,
                'max_budget' => 3400,
                'best_months' => [4, 5, 6, 9, 10],
                'activities' => ['Culture', 'Relaxation', 'Food'],
                'image_url' => 'https://images.unsplash.com/photo-1527631746610-bca00a040d60?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Maldives',
                'location' => 'Maldives',
                'description' => 'Luxury overwater bungalows, crystal lagoons, and vibrant coral reefs.',
                'min_budget' => 1800,
                'max_budget' => 6000,
                'best_months' => [12, 1, 2, 3, 4],
                'activities' => ['Relaxation', 'Nature', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Phuket',
                'location' => 'Thailand',
                'description' => 'Beautiful island beaches, night markets, and fantastic water sports.',
                'min_budget' => 450,
                'max_budget' => 1900,
                'best_months' => [11, 12, 1, 2, 3, 4],
                'activities' => ['Relaxation', 'Nightlife', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1589308078059-be1415eab4c3?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Santorini',
                'location' => 'Greece',
                'description' => 'Breathtaking volcanic caldera views, blue domes, and sunset seas.',
                'min_budget' => 1000,
                'max_budget' => 3800,
                'best_months' => [5, 6, 7, 8, 9, 10],
                'activities' => ['Relaxation', 'Culture', 'Food'],
                'image_url' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Reykjavik',
                'location' => 'Iceland',
                'description' => 'Geothermal hot springs, glaciers, and mesmerizing Northern Lights.',
                'min_budget' => 1300,
                'max_budget' => 4500,
                'best_months' => [10, 11, 12, 1, 2, 6, 7, 8],
                'activities' => ['Nature', 'Adventure', 'Relaxation'],
                'image_url' => 'https://images.unsplash.com/photo-1517411032315-54ef2cb783bb?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Queenstown',
                'location' => 'New Zealand',
                'description' => 'Adventure capital of the world, offering bungee jumps and ski slopes.',
                'min_budget' => 1200,
                'max_budget' => 4200,
                'best_months' => [12, 1, 2, 6, 7, 8],
                'activities' => ['Adventure', 'Nature'],
                'image_url' => 'https://images.unsplash.com/photo-1589871190901-b84483a936a6?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Machu Picchu',
                'location' => 'Peru',
                'description' => 'Ancient Incan citadel perched high in the Andes mountains.',
                'min_budget' => 950,
                'max_budget' => 3200,
                'best_months' => [5, 6, 7, 8, 9],
                'activities' => ['Adventure', 'Culture', 'Nature'],
                'image_url' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Vancouver',
                'location' => 'Canada',
                'description' => 'Vibrant urban center surrounded by majestic sea and snowy peaks.',
                'min_budget' => 1000,
                'max_budget' => 3800,
                'best_months' => [6, 7, 8, 9],
                'activities' => ['Nature', 'Adventure', 'Food'],
                'image_url' => 'https://images.unsplash.com/photo-1559511260-66a654ae982a?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Maui',
                'location' => 'Hawaii',
                'description' => 'Pristine beaches, sacred valleys, and humpback whale migrations.',
                'min_budget' => 1400,
                'max_budget' => 5000,
                'best_months' => [4, 5, 9, 10, 11, 12],
                'activities' => ['Relaxation', 'Nature', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1542856391-010fb87dcfed?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Istanbul',
                'location' => 'Turkey',
                'description' => 'Bridging Europe and Asia, famous for spice bazaars and grand mosques.',
                'min_budget' => 500,
                'max_budget' => 2200,
                'best_months' => [4, 5, 6, 9, 10, 11],
                'activities' => ['Culture', 'Food', 'Relaxation'],
                'image_url' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        foreach ($destinations as $d) {
            $acts = $d['activities'];
            unset($d['activities']);
            $dest = Destination::create($d);
            foreach ($acts as $actName) {
                $dest->activities()->attach($activities[$actName]->id);
            }
        }

        // Seed Hotels and Airbnbs
        $hotels = [
            'Bali' => [
                [
                    'name' => 'Ubud Hanging Gardens Resort',
                    'type' => 'hotel',
                    'location' => 'Ubud, Bali',
                    'description' => 'Luxurious resort featuring a stunning split-level infinity pool suspended over the lush rainforest valley. Rejuvenate at the world-class spa and savor organic local cuisine.',
                    'price_per_night' => 380,
                    'rating' => 4.92,
                    'rooms_available' => 6,
                    'amenities' => ['Wifi', 'Pool', 'Spa', 'Restaurant', 'Air Conditioning', 'Free Parking', 'Fitness Center'],
                    'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
                    'latitude' => -8.506854,
                    'longitude' => 115.262482
                ],
                [
                    'name' => 'Eco-Bamboo Treehouse in Ubud',
                    'type' => 'airbnb',
                    'location' => 'Ubud, Bali',
                    'description' => 'Stunning eco-villa constructed entirely from sustainably sourced giant bamboo, nestled deep in Balinese rice paddies. Wake up to the sounds of flowing river waters and birds chirping.',
                    'price_per_night' => 95,
                    'rating' => 4.88,
                    'rooms_available' => 2,
                    'amenities' => ['Wifi', 'Kitchen', 'Pool', 'Free Parking', 'Pet Friendly'],
                    'image_url' => 'https://images.unsplash.com/photo-1508333706533-1ab43ecb1606?auto=format&fit=crop&w=800&q=80',
                    'latitude' => -8.514681,
                    'longitude' => 115.275812
                ]
            ],
            'Swiss Alps' => [
                [
                    'name' => 'The Alpine Palace & Spa',
                    'type' => 'hotel',
                    'location' => 'Zermatt, Switzerland',
                    'description' => 'Five-star historic hotel featuring breathtaking, unobstructed views of the iconic Matterhorn peak. Enjoy ski-in/ski-out access, a heated pool, and cozy Michelin-starred alpine dining.',
                    'price_per_night' => 480,
                    'rating' => 4.95,
                    'rooms_available' => 4,
                    'amenities' => ['Wifi', 'Pool', 'Spa', 'Restaurant', 'Ski Access', 'Bar', 'Gym', 'Free Breakfast'],
                    'image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 46.020714,
                    'longitude' => 7.749117
                ],
                [
                    'name' => 'Cozy Luxury Chalet with Hot Tub',
                    'type' => 'airbnb',
                    'location' => 'Grindelwald, Switzerland',
                    'description' => 'Charming modern Swiss chalet offering rustic comfort, a roaring stone fireplace, and a private outdoor hot tub facing the Eiger mountain wall. Perfect for summer hiking and winter ski trips.',
                    'price_per_night' => 210,
                    'rating' => 4.87,
                    'rooms_available' => 1,
                    'amenities' => ['Wifi', 'Kitchen', 'Hot Tub', 'Fireplace', 'Washing Machine', 'Free Parking'],
                    'image_url' => 'https://images.unsplash.com/photo-1502784444187-359ac186c5bb?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 46.624231,
                    'longitude' => 8.041394
                ]
            ],
            'Paris' => [
                [
                    'name' => 'Hotel Plaza Athénée Paris',
                    'type' => 'hotel',
                    'location' => 'Avenue Montaigne, Paris',
                    'description' => 'Famed luxury palace hotel featuring classic French decor, signature red awnings, a secluded inner garden courtyard, and Michelin dining by the finest chefs in France.',
                    'price_per_night' => 820,
                    'rating' => 4.94,
                    'rooms_available' => 5,
                    'amenities' => ['Wifi', 'Air Conditioning', 'Spa', 'Restaurant', 'Bar', 'Gym', 'Room Service'],
                    'image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 48.865912,
                    'longitude' => 2.302581
                ],
                [
                    'name' => 'Charming Artist Loft in Montmartre',
                    'type' => 'airbnb',
                    'location' => 'Montmartre, Paris',
                    'description' => 'Light-filled artistic apartment at the base of the Sacré-Cœur Basilica. Features exposed wooden beams, clawfoot tub, local art collection, and double doors opening onto a scenic cobbled lane.',
                    'price_per_night' => 135,
                    'rating' => 4.79,
                    'rooms_available' => 3,
                    'amenities' => ['Wifi', 'Kitchen', 'Washing Machine', 'Air Conditioning', 'Coffee Maker'],
                    'image_url' => 'https://images.unsplash.com/photo-1499856133078-5d9cd4e05b67?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 48.886512,
                    'longitude' => 2.343110
                ]
            ],
            'Kyoto' => [
                [
                    'name' => 'Gion restored 100-Year-Old Machiya',
                    'type' => 'airbnb',
                    'location' => 'Gion, Kyoto',
                    'description' => 'Beautifully restored traditional wooden townhouse offering authentic tatami rooms, sliding shoji screens, a stone pocket garden, and absolute peace in the heart of Gion district.',
                    'price_per_night' => 170,
                    'rating' => 4.91,
                    'rooms_available' => 2,
                    'amenities' => ['Wifi', 'Kitchen', 'Air Conditioning', 'Washing Machine', 'Garden'],
                    'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 35.003651,
                    'longitude' => 135.778219
                ],
                [
                    'name' => 'Kyoto Riverview Luxury Ryokan',
                    'type' => 'hotel',
                    'location' => 'Higashiyama, Kyoto',
                    'description' => 'Exquisite, authentic Japanese ryokan offering luxury tatami suites, multi-course seasonal Kaiseki dining, and healing private hinoki cypress wood hot baths overlooking Kamogawa River.',
                    'price_per_night' => 420,
                    'rating' => 4.89,
                    'rooms_available' => 5,
                    'amenities' => ['Wifi', 'Spa', 'Restaurant', 'Air Conditioning', 'Free Breakfast', 'Hot Tub'],
                    'image_url' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 34.996152,
                    'longitude' => 135.772581
                ]
            ],
            'Tokyo' => [
                [
                    'name' => 'Park Hyatt Tokyo',
                    'type' => 'hotel',
                    'location' => 'Shinjuku, Tokyo',
                    'description' => 'Iconic soaring luxury hotel offering 360-degree panoramic Tokyo skyline views, a 47th-floor glass-enclosed indoor pool, a world-class jazz bar, and exceptional luxury service.',
                    'price_per_night' => 610,
                    'rating' => 4.96,
                    'rooms_available' => 8,
                    'amenities' => ['Wifi', 'Pool', 'Gym', 'Spa', 'Restaurant', 'Bar', 'Air Conditioning', 'Fitness Center'],
                    'image_url' => 'https://images.unsplash.com/photo-1540959733332-eab4deceeaf7?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 35.685352,
                    'longitude' => 139.691235
                ],
                [
                    'name' => 'Modern Minimalist Studio in Shibuya',
                    'type' => 'airbnb',
                    'location' => 'Shibuya, Tokyo',
                    'description' => 'Sleek, award-winning studio apartment situated in a quiet, design-forward Shibuya street. Features high-speed pocket wifi and absolute proximity to Tokyo’s top dining spots.',
                    'price_per_night' => 105,
                    'rating' => 4.76,
                    'rooms_available' => 3,
                    'amenities' => ['Wifi', 'Kitchen', 'Air Conditioning', 'Pocket Wifi', 'Washing Machine'],
                    'image_url' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 35.661781,
                    'longitude' => 139.704021
                ]
            ],
            'New York' => [
                [
                    'name' => 'The Plaza Hotel Fifth Avenue',
                    'type' => 'hotel',
                    'location' => 'Midtown East, New York',
                    'description' => 'Fabled New York City luxury landmark overlooking Central Park. Offers regal gold-plated fixtures, classic butler service, the legendary Palm Court, and ultimate Manhattan grandeur.',
                    'price_per_night' => 680,
                    'rating' => 4.90,
                    'rooms_available' => 7,
                    'amenities' => ['Wifi', 'Air Conditioning', 'Gym', 'Spa', 'Restaurant', 'Bar', 'Room Service'],
                    'image_url' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 40.764512,
                    'longitude' => -73.974421
                ],
                [
                    'name' => 'SOHO Luxury Exposed Brick Loft',
                    'type' => 'airbnb',
                    'location' => 'Soho, New York',
                    'description' => 'Classic, sprawling Soho artist loft in a cast-iron building. Features 14-foot ceilings, huge factory windows, a chef\'s kitchen, an expansive living area, and elegant modern furnishings.',
                    'price_per_night' => 240,
                    'rating' => 4.84,
                    'rooms_available' => 2,
                    'amenities' => ['Wifi', 'Kitchen', 'Air Conditioning', 'Washing Machine', 'Elevator', 'Gym'],
                    'image_url' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 40.723151,
                    'longitude' => -74.001254
                ]
            ],
            'London' => [
                [
                    'name' => 'The Savoy Hotel London',
                    'type' => 'hotel',
                    'location' => 'Strand, London',
                    'description' => 'World-famous historic hotel on the banks of the River Thames. Features exceptional Edwardian and Art Deco suites, butler service, and the finest afternoon high tea in Great Britain.',
                    'price_per_night' => 540,
                    'rating' => 4.92,
                    'rooms_available' => 4,
                    'amenities' => ['Wifi', 'Air Conditioning', 'Gym', 'Spa', 'Restaurant', 'Bar', 'Free Breakfast'],
                    'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 51.509852,
                    'longitude' => -0.120251
                ],
                [
                    'name' => 'Charming Pastel Flat in Notting Hill',
                    'type' => 'airbnb',
                    'location' => 'Notting Hill, London',
                    'description' => 'Delightful, light-filled flat situated inside a classic colorful Victorian terrace house. Seconds away from Portobello Market, complete with a private, flower-filled balcony.',
                    'price_per_night' => 150,
                    'rating' => 4.81,
                    'rooms_available' => 2,
                    'amenities' => ['Wifi', 'Kitchen', 'Washing Machine', 'Balcony', 'Fireplace'],
                    'image_url' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 51.515234,
                    'longitude' => -0.201254
                ]
            ],
            'Rome' => [
                [
                    'name' => 'Colosseum View Penthouse Terrace',
                    'type' => 'airbnb',
                    'location' => 'Monti, Rome',
                    'description' => 'Spectacular private penthouse apartment featuring a massive private terracotta terrace with absolutely direct, unobstructed views of the Colosseum. Perfect for sunset dinners.',
                    'price_per_night' => 195,
                    'rating' => 4.94,
                    'rooms_available' => 2,
                    'amenities' => ['Wifi', 'Kitchen', 'Air Conditioning', 'Terrace', 'Washing Machine', 'Coffee Maker'],
                    'image_url' => 'https://images.unsplash.com/photo-1515263487990-61b07816b324?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 41.890251,
                    'longitude' => 12.492582
                ]
            ],
            'Sydney' => [
                [
                    'name' => 'Park Hyatt Sydney Harbor',
                    'type' => 'hotel',
                    'location' => 'The Rocks, Sydney',
                    'description' => 'Spectacular waterfront luxury hotel nestled right beneath the Sydney Harbour Bridge. Offers unobstructed, majestic views directly facing the Sydney Opera House and a rooftop heated pool.',
                    'price_per_night' => 510,
                    'rating' => 4.97,
                    'rooms_available' => 6,
                    'amenities' => ['Wifi', 'Pool', 'Gym', 'Spa', 'Restaurant', 'Bar', 'Air Conditioning'],
                    'image_url' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=800&q=80',
                    'latitude' => -33.856852,
                    'longitude' => 151.215254
                ]
            ],
            'Maldives' => [
                [
                    'name' => 'Soneva Jani Luxury Water Villa',
                    'type' => 'hotel',
                    'location' => 'Noonu Atoll, Maldives',
                    'description' => 'The epitome of overwater luxury. Features massive split-level villas with private lagoon pools, waterslides straight into the ocean, retractable roofs for stargazing, and private dining.',
                    'price_per_night' => 1350,
                    'rating' => 4.98,
                    'rooms_available' => 3,
                    'amenities' => ['Wifi', 'Pool', 'Spa', 'Restaurant', 'Bar', 'Air Conditioning', 'Free Breakfast', 'Water Slide'],
                    'image_url' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?auto=format&fit=crop&w=800&q=80',
                    'latitude' => 5.661234,
                    'longitude' => 73.342154
                ]
            ]
        ];

        foreach ($hotels as $destName => $propertyList) {
            $destination = Destination::where('name', $destName)->first();
            if ($destination) {
                foreach ($propertyList as $p) {
                    $p['destination_id'] = $destination->id;
                    \App\Models\Hotel::create($p);
                }
            }
        }
    }
}

