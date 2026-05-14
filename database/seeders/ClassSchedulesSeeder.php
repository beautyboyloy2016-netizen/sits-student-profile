<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSchedulesSeeder extends Seeder
{
    public function run(): void
    {
        // day_of_week => class_code pattern
        $schedules = [
            'ENG-BEG%' => [
                ['day_of_week' => 'monday',    'start_time' => '07:00:00', 'end_time' => '09:00:00'],
                ['day_of_week' => 'wednesday',  'start_time' => '07:00:00', 'end_time' => '09:00:00'],
                ['day_of_week' => 'friday',     'start_time' => '07:00:00', 'end_time' => '09:00:00'],
            ],
            'ENG-INT%' => [
                ['day_of_week' => 'tuesday',    'start_time' => '13:00:00', 'end_time' => '15:00:00'],
                ['day_of_week' => 'thursday',   'start_time' => '13:00:00', 'end_time' => '15:00:00'],
                ['day_of_week' => 'saturday',   'start_time' => '13:00:00', 'end_time' => '15:00:00'],
            ],
            'KHM-%' => [
                ['day_of_week' => 'monday',    'start_time' => '07:00:00', 'end_time' => '09:00:00'],
                ['day_of_week' => 'wednesday',  'start_time' => '07:00:00', 'end_time' => '09:00:00'],
            ],
            'MTH-%' => [
                ['day_of_week' => 'monday',    'start_time' => '17:30:00', 'end_time' => '19:30:00'],
                ['day_of_week' => 'wednesday',  'start_time' => '17:30:00', 'end_time' => '19:30:00'],
                ['day_of_week' => 'friday',     'start_time' => '17:30:00', 'end_time' => '19:30:00'],
            ],
            'CS-%' => [
                ['day_of_week' => 'saturday',  'start_time' => '08:00:00', 'end_time' => '11:00:00'],
                ['day_of_week' => 'sunday',     'start_time' => '08:00:00', 'end_time' => '11:00:00'],
            ],
            'CHN-%' => [
                ['day_of_week' => 'tuesday',   'start_time' => '13:00:00', 'end_time' => '15:00:00'],
                ['day_of_week' => 'thursday',   'start_time' => '13:00:00', 'end_time' => '15:00:00'],
            ],
        ];

        foreach ($schedules as $classPattern => $days) {
            $classId = DB::table('classes')->where('class_code', 'like', $classPattern)->value('id');
            if (!$classId) {
                continue;
            }

            foreach ($days as $day) {
                $exists = DB::table('class_schedules')
                    ->where('class_id', $classId)
                    ->where('day_of_week', $day['day_of_week'])
                    ->exists();

                if (!$exists) {
                    DB::table('class_schedules')->insert($day + [
                        'class_id'   => $classId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
