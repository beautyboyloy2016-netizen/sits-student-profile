<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\District;
use App\Models\Commune;
use App\Models\Course;
use App\Models\Level;
use App\Models\AcademicYear;
use App\Models\Shift;

class BasicDataSeeder extends Seeder
{
    public function run(): void
    {
        // Provinces (Cambodia)
        $provinces = [
            ['code' => '01', 'name_kh' => 'បន្ទាយមានជ័យ', 'name_en' => 'Banteay Meanchey'],
            ['code' => '02', 'name_kh' => 'បាត់ដំបង', 'name_en' => 'Battambang'],
            ['code' => '03', 'name_kh' => 'កំពង់ចាម', 'name_en' => 'Kampong Cham'],
            ['code' => '04', 'name_kh' => 'កំពង់ឆ្នាំង', 'name_en' => 'Kampong Chhnang'],
            ['code' => '05', 'name_kh' => 'កំពង់ស្ពឺ', 'name_en' => 'Kampong Speu'],
            ['code' => '06', 'name_kh' => 'កំពង់ធំ', 'name_en' => 'Kampong Thom'],
            ['code' => '07', 'name_kh' => 'កំពត', 'name_en' => 'Kampot'],
            ['code' => '08', 'name_kh' => 'កណ្ដាល', 'name_en' => 'Kandal'],
            ['code' => '09', 'name_kh' => 'កោះកុង', 'name_en' => 'Koh Kong'],
            ['code' => '10', 'name_kh' => 'ក្រចេះ', 'name_en' => 'Kratie'],
            ['code' => '11', 'name_kh' => 'មណ្ឌលគិរី', 'name_en' => 'Mondulkiri'],
            ['code' => '12', 'name_kh' => 'ភ្នំពេញ', 'name_en' => 'Phnom Penh'],
            ['code' => '13', 'name_kh' => 'ព្រះវិហារ', 'name_en' => 'Preah Vihear'],
            ['code' => '14', 'name_kh' => 'ព្រៃវែង', 'name_en' => 'Prey Veng'],
            ['code' => '15', 'name_kh' => 'ពោធិ៍សាត់', 'name_en' => 'Pursat'],
            ['code' => '16', 'name_kh' => 'រតនគិរី', 'name_en' => 'Ratanakiri'],
            ['code' => '17', 'name_kh' => 'សៀមរាប', 'name_en' => 'Siem Reap'],
            ['code' => '18', 'name_kh' => 'ព្រះសីហនុ', 'name_en' => 'Preah Sihanouk'],
            ['code' => '19', 'name_kh' => 'ស្ទឹងត្រែង', 'name_en' => 'Stung Treng'],
            ['code' => '20', 'name_kh' => 'ស្វាយរៀង', 'name_en' => 'Svay Rieng'],
            ['code' => '21', 'name_kh' => 'តាកែវ', 'name_en' => 'Takeo'],
            ['code' => '22', 'name_kh' => 'ឧត្ដរមានជ័យ', 'name_en' => 'Oddar Meanchey'],
            ['code' => '23', 'name_kh' => 'កែប', 'name_en' => 'Kep'],
            ['code' => '24', 'name_kh' => 'ប៉ៃលិន', 'name_en' => 'Pailin'],
            ['code' => '25', 'name_kh' => 'ត្បូងឃ្មុំ', 'name_en' => 'Tboung Khmum'],
        ];

        foreach ($provinces as $p) {
            Province::firstOrCreate(['code' => $p['code']], $p);
        }

        // Academic Year
        AcademicYear::firstOrCreate(
            ['name' => '2025-2026'],
            ['start_date' => '2025-09-01', 'end_date' => '2026-07-31', 'is_current' => true, 'status' => 'active']
        );

        // Shifts
        Shift::firstOrCreate(['name' => 'Morning'], ['start_time' => '07:00:00', 'end_time' => '11:00:00', 'status' => 'active']);
        Shift::firstOrCreate(['name' => 'Afternoon'], ['start_time' => '13:00:00', 'end_time' => '17:00:00', 'status' => 'active']);
        Shift::firstOrCreate(['name' => 'Evening'], ['start_time' => '17:30:00', 'end_time' => '21:00:00', 'status' => 'active']);

        // Sample Course
        $course = Course::firstOrCreate(
            ['name' => 'General English'],
            ['description' => 'General English program for all levels.', 'status' => 'active']
        );

        Level::firstOrCreate(['course_id' => $course->id, 'name' => 'Beginner', 'sort_order' => 1]);
        Level::firstOrCreate(['course_id' => $course->id, 'name' => 'Elementary', 'sort_order' => 2]);
        Level::firstOrCreate(['course_id' => $course->id, 'name' => 'Pre-Intermediate', 'sort_order' => 3]);
        Level::firstOrCreate(['course_id' => $course->id, 'name' => 'Intermediate', 'sort_order' => 4]);
        Level::firstOrCreate(['course_id' => $course->id, 'name' => 'Upper-Intermediate', 'sort_order' => 5]);
        Level::firstOrCreate(['course_id' => $course->id, 'name' => 'Advanced', 'sort_order' => 6]);
    }
}
