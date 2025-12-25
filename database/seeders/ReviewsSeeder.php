<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'Maria S.',
                'rating' => 5,
                'comment' => 'Check-in was smooth, rooms were spotless, and the vibe feels premium without being loud.',
                'is_approved' => true,
            ],
            [
                'name' => 'Ken D.',
                'rating' => 5,
                'comment' => 'The minimalist interiors are beautiful. Fast Wi-Fi, great lighting, and super quiet at night.',
                'is_approved' => true,
            ],
            [
                'name' => 'Anne P.',
                'rating' => 5,
                'comment' => 'Suite was stunning. Service was quick and thoughtful. Would book again immediately.',
                'is_approved' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
