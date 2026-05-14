<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearsShiftsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Academic Years ────────────────────────────────────────────────
        $years = [
            ['name' => '2023-2024', 'start_date' => '2023-09-01', 'end_date' => '2024-06-30', 'is_current' => false, 'status' => 'closed'],
            ['name' => '2024-2025', 'start_date' => '2024-09-01', 'end_date' => '2025-06-30', 'is_current' => false, 'status' => 'closed'],
            ['name' => '2025-2026', 'start_date' => '2025-09-01', 'end_date' => '2026-06-30', 'is_current' => true,  'status' => 'active'],
            ['name' => '2026-2027', 'start_date' => '2026-09-01', 'end_date' => '2027-06-30', 'is_current' => false, 'status' => 'inactive'],
        ];

        foreach ($years as $year) {
            DB::table('academic_years')->insertOrIgnore(
                $year + ['created_at' => now(), 'updated_at' => now()]
            );
        }

        // ── Shifts ────────────────────────────────────────────────────────
        $shifts = [
            ['name' => 'Morning',   'start_time' => '07:00:00', 'end_time' => '11:00:00', 'status' => 'active'],
            ['name' => 'Afternoon', 'start_time' => '13:00:00', 'end_time' => '17:00:00', 'status' => 'active'],
            ['name' => 'Evening',   'start_time' => '17:30:00', 'end_time' => '20:30:00', 'status' => 'active'],
            ['name' => 'Weekend',   'start_time' => '08:00:00', 'end_time' => '12:00:00', 'status' => 'active'],
        ];

        foreach ($shifts as $shift) {
            DB::table('shifts')->insertOrIgnore(
                $shift + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
