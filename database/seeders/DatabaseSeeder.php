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
                'best_months' => [4, 5, 6, 7, 8, 9, 10], // Dry season
                'activities' => ['Relaxation', 'Nature', 'Culture'],
                'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Swiss Alps',
                'location' => 'Switzerland',
                'description' => 'Stunning mountains, perfect for skiing in winter and hiking in summer.',
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
                'description' => 'A city that preserves old Japan with temples, gardens, and palaces.',
                'min_budget' => 800,
                'max_budget' => 3000,
                'best_months' => [3, 4, 10, 11], // Cherry blossom and Autumn
                'activities' => ['Culture', 'Relaxation', 'Nature'],
                'image_url' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'name' => 'Cape Town',
                'location' => 'South Africa',
                'description' => 'A port city on South Africa’s southwest coast, on a peninsula beneath the imposing Table Mountain.',
                'min_budget' => 700,
                'max_budget' => 2500,
                'best_months' => [11, 12, 1, 2, 3], // Summer
                'activities' => ['Nature', 'Food', 'Adventure'],
                'image_url' => 'https://images.unsplash.com/photo-1580619305218-8423a7ef79b4?auto=format&fit=crop&w=800&q=80'
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
