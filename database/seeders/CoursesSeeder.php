<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name'        => 'English Language',
                'description' => 'General English from beginner to advanced',
                'status'      => 'active',
                'levels'      => ['Beginner', 'Elementary', 'Pre-Intermediate', 'Intermediate', 'Upper-Intermediate', 'Advanced'],
            ],
            [
                'name'        => 'Khmer Language',
                'description' => 'Khmer reading, writing and grammar',
                'status'      => 'active',
                'levels'      => ['Grade 1', 'Grade 2', 'Grade 3'],
            ],
            [
                'name'        => 'Mathematics',
                'description' => 'Mathematics from basic to calculus',
                'status'      => 'active',
                'levels'      => ['Basic', 'Intermediate', 'Advanced'],
            ],
            [
                'name'        => 'Computer Science',
                'description' => 'Programming and IT fundamentals',
                'status'      => 'active',
                'levels'      => ['Fundamental', 'Web Development', 'Database', 'Networking'],
            ],
            [
                'name'        => 'Chinese Language',
                'description' => 'Mandarin Chinese from HSK1 to HSK6',
                'status'      => 'active',
                'levels'      => ['HSK 1', 'HSK 2', 'HSK 3', 'HSK 4', 'HSK 5', 'HSK 6'],
            ],
            [
                'name'        => 'Accounting',
                'description' => 'Bookkeeping and financial accounting',
                'status'      => 'active',
                'levels'      => ['Basic Accounting', 'Advanced Accounting'],
            ],
        ];

        foreach ($courses as $courseData) {
            $levels = $courseData['levels'];
            unset($courseData['levels']);

            $existingId = DB::table('courses')->where('name', $courseData['name'])->value('id');
            if (!$existingId) {
                $existingId = DB::table('courses')->insertGetId(
                    $courseData + ['created_at' => now(), 'updated_at' => now()]
                );
            }

            foreach ($levels as $index => $levelName) {
                DB::table('levels')->insertOrIgnore([
                    'course_id'  => $existingId,
                    'name'       => $levelName,
                    'sort_order' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
