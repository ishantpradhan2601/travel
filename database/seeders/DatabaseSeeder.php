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
                'image_url' => 'https://images.unsplash.com/photo-1504829857797-ddff28127792?auto=format&fit=crop&w=800&q=80'
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
    }
}
