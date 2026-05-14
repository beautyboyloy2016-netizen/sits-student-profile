<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeeTypesSeeder extends Seeder
{
    public function run(): void
    {
        $feeTypes = [
            ['name' => 'Registration Fee',     'amount' => 10.00,  'status' => 'active'],
            ['name' => 'Monthly Tuition',       'amount' => 30.00,  'status' => 'active'],
            ['name' => 'Material / Book Fee',   'amount' => 15.00,  'status' => 'active'],
            ['name' => 'Exam Fee',              'amount' => 5.00,   'status' => 'active'],
            ['name' => 'Certificate Fee',       'amount' => 10.00,  'status' => 'active'],
            ['name' => 'Student Card Fee',      'amount' => 2.00,   'status' => 'active'],
            ['name' => 'Diploma Fee',           'amount' => 20.00,  'status' => 'active'],
            ['name' => 'Room Rental',           'amount' => 60.00,  'status' => 'active'],
            ['name' => 'Late Payment Penalty',  'amount' => 2.00,   'status' => 'active'],
            ['name' => 'Other',                 'amount' => 0.00,   'status' => 'active'],
        ];

        foreach ($feeTypes as $fee) {
            DB::table('fee_types')->insertOrIgnore(
                $fee + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
