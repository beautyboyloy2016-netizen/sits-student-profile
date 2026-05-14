<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingsRoomsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Buildings ─────────────────────────────────────────────────────
        $buildings = [
            ['name' => 'Building A', 'status' => 'active'],
            ['name' => 'Building B', 'status' => 'active'],
            ['name' => 'Building C', 'status' => 'active'],
        ];

        foreach ($buildings as $building) {
            $buildingId = DB::table('buildings')->where('name', $building['name'])->value('id');
            if (!$buildingId) {
                $buildingId = DB::table('buildings')->insertGetId(
                    $building + ['created_at' => now(), 'updated_at' => now()]
                );
            }

            // ── Rooms per building ────────────────────────────────────────
            $rooms = match ($building['name']) {
                'Building A' => [
                    ['room_no' => 'A101', 'room_type' => 'classroom', 'capacity' => 30, 'monthly_price' => 0,   'status' => 'available'],
                    ['room_no' => 'A102', 'room_type' => 'classroom', 'capacity' => 30, 'monthly_price' => 0,   'status' => 'available'],
                    ['room_no' => 'A103', 'room_type' => 'classroom', 'capacity' => 25, 'monthly_price' => 0,   'status' => 'available'],
                    ['room_no' => 'A201', 'room_type' => 'classroom', 'capacity' => 40, 'monthly_price' => 0,   'status' => 'available'],
                    ['room_no' => 'A202', 'room_type' => 'classroom', 'capacity' => 40, 'monthly_price' => 0,   'status' => 'available'],
                ],
                'Building B' => [
                    ['room_no' => 'B101', 'room_type' => 'shared',    'capacity' => 4,  'monthly_price' => 60,  'status' => 'available'],
                    ['room_no' => 'B102', 'room_type' => 'shared',    'capacity' => 4,  'monthly_price' => 60,  'status' => 'available'],
                    ['room_no' => 'B103', 'room_type' => 'double',    'capacity' => 2,  'monthly_price' => 100, 'status' => 'available'],
                    ['room_no' => 'B201', 'room_type' => 'single',    'capacity' => 1,  'monthly_price' => 150, 'status' => 'available'],
                    ['room_no' => 'B202', 'room_type' => 'single',    'capacity' => 1,  'monthly_price' => 150, 'status' => 'available'],
                ],
                'Building C' => [
                    ['room_no' => 'C101', 'room_type' => 'classroom', 'capacity' => 50, 'monthly_price' => 0,   'status' => 'available'],
                    ['room_no' => 'C102', 'room_type' => 'classroom', 'capacity' => 50, 'monthly_price' => 0,   'status' => 'available'],
                    ['room_no' => 'C201', 'room_type' => 'classroom', 'capacity' => 35, 'monthly_price' => 0,   'status' => 'available'],
                ],
                default => [],
            };

            foreach ($rooms as $room) {
                DB::table('rooms')->insertOrIgnore(
                    $room + ['building_id' => $buildingId, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
