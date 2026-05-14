<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersSeeder extends Seeder
{
    public function run(): void
    {
        $genders = [
            ['name_kh' => 'ប្រុស',  'name_en' => 'Male',   'sort_order' => 1],
            ['name_kh' => 'ស្រី',   'name_en' => 'Female', 'sort_order' => 2],
            ['name_kh' => 'ផ្សេងៗ', 'name_en' => 'Other',  'sort_order' => 3],
        ];

        foreach ($genders as $gender) {
            DB::table('genders')->insertOrIgnore(
                $gender + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
