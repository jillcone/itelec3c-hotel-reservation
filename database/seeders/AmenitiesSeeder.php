<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            [
                'amenity_name' => 'Infinity Pool',
                'description' => 'A calm space to unwind.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => 'Spa & Wellness',
                'description' => 'Massage and sauna options.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => 'Fitness Studio',
                'description' => 'Modern equipment and towels.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => 'High-Speed Wi‑Fi',
                'description' => 'Work & streaming ready.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => 'Airport Transfer',
                'description' => 'Convenient pickup on request.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => 'Laundry Service',
                'description' => 'Same-day options available.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => 'Secure Parking',
                'description' => 'Safe and accessible.',
                'price_per_use' => 0.00,
            ],
            [
                'amenity_name' => '24/7 Concierge',
                'description' => 'We respond quickly.',
                'price_per_use' => 0.00,
            ],
        ];

        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(
                ['amenity_name' => $amenity['amenity_name']],
                $amenity
            );
        }
    }
}
