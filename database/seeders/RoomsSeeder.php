<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => '101',
                'room_type' => 'Standard Room',
                'description' => 'Minimalist comfort for solo stays and short trips.',
                'capacity' => 2,
                'price_per_night' => 2499.00,
                'availability_status' => 'available',
            ],
            [
                'room_number' => '102',
                'room_type' => 'Double Room',
                'description' => 'Ideal for couples, featuring a spacious double bed and cozy interiors.',
                'capacity' => 2,
                'price_per_night' => 2999.00,
                'availability_status' => 'available',
            ],
            [
                'room_number' => '103',
                'room_type' => 'Deluxe Room',
                'description' => 'More space, better views, and a premium feel.',
                'capacity' => 2,
                'price_per_night' => 3699.00,
                'availability_status' => 'available',
            ],
            [
                'room_number' => '201',
                'room_type' => 'Family Room',
                'description' => 'Designed for families, offering extra space and multiple sleeping options.',
                'capacity' => 4,
                'price_per_night' => 4999.00,
                'availability_status' => 'available',
            ],
            [
                'room_number' => '301',
                'room_type' => 'Aurum Suite',
                'description' => 'Lounge area + spa-style bath for long stays.',
                'capacity' => 2,
                'price_per_night' => 6999.00,
                'availability_status' => 'available',
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['room_number' => $room['room_number']],
                $room
            );
        }
    }
}
