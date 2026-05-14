<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = DB::table('academic_years')->where('is_current', true)->first();
        if (!$currentYear) {
            $this->command->warn('No current academic year found. Skipping ClassesSeeder.');
            return;
        }

        $mainBranchId = DB::table('branches')->where('is_main', true)->value('id');
        $morningShift   = DB::table('shifts')->where('name', 'Morning')->first();
        $afternoonShift = DB::table('shifts')->where('name', 'Afternoon')->first();
        $eveningShift   = DB::table('shifts')->where('name', 'Evening')->first();
        $weekendShift   = DB::table('shifts')->where('name', 'Weekend')->first();

        $classroomA101 = DB::table('rooms')->where('room_no', 'A101')->value('id');
        $classroomA102 = DB::table('rooms')->where('room_no', 'A102')->value('id');
        $classroomA201 = DB::table('rooms')->where('room_no', 'A201')->value('id');
        $classroomC101 = DB::table('rooms')->where('room_no', 'C101')->value('id');

        // Staff IDs
        $teacher001 = DB::table('staff')->where('staff_code', 'TCH-001')->value('id'); // English
        $teacher002 = DB::table('staff')->where('staff_code', 'TCH-002')->value('id'); // Khmer
        $teacher003 = DB::table('staff')->where('staff_code', 'TCH-003')->value('id'); // Math
        $teacher004 = DB::table('staff')->where('staff_code', 'TCH-004')->value('id'); // CS
        $teacher005 = DB::table('staff')->where('staff_code', 'TCH-005')->value('id'); // Chinese

        // Course & level IDs
        $englishCourse  = DB::table('courses')->where('name', 'English Language')->value('id');
        $khmerCourse    = DB::table('courses')->where('name', 'Khmer Language')->value('id');
        $mathCourse     = DB::table('courses')->where('name', 'Mathematics')->value('id');
        $csCourse       = DB::table('courses')->where('name', 'Computer Science')->value('id');
        $chineseCourse  = DB::table('courses')->where('name', 'Chinese Language')->value('id');

        $engBegLevel = DB::table('levels')->where('course_id', $englishCourse)->where('name', 'Beginner')->value('id');
        $engIntLevel = DB::table('levels')->where('course_id', $englishCourse)->where('name', 'Intermediate')->value('id');
        $mathBasic   = DB::table('levels')->where('course_id', $mathCourse)->where('name', 'Basic')->value('id');
        $csLevel     = DB::table('levels')->where('course_id', $csCourse)->where('name', 'Fundamental')->value('id');
        $hsk1Level   = DB::table('levels')->where('course_id', $chineseCourse)->where('name', 'HSK 1')->value('id');
        $khmerG1     = DB::table('levels')->where('course_id', $khmerCourse)->where('name', 'Grade 1')->value('id');

        $classes = [
            [
                'class_code'       => 'ENG-BEG-MOR-' . $currentYear->name,
                'course_id'        => $englishCourse,
                'level_id'         => $engBegLevel,
                'academic_year_id' => $currentYear->id,
                'shift_id'         => $morningShift?->id,
                'teacher_id'       => $teacher001,
                'room_id'          => $classroomA101,
                'branch_id'        => $mainBranchId,
                'start_date'       => $currentYear->start_date,
                'end_date'         => $currentYear->end_date,
                'status'           => 'active',
            ],
            [
                'class_code'       => 'ENG-INT-AFT-' . $currentYear->name,
                'course_id'        => $englishCourse,
                'level_id'         => $engIntLevel,
                'academic_year_id' => $currentYear->id,
                'shift_id'         => $afternoonShift?->id,
                'teacher_id'       => $teacher001,
                'room_id'          => $classroomA102,
                'branch_id'        => $mainBranchId,
                'start_date'       => $currentYear->start_date,
                'end_date'         => $currentYear->end_date,
                'status'           => 'active',
            ],
            [
                'class_code'       => 'KHM-G1-MOR-' . $currentYear->name,
                'course_id'        => $khmerCourse,
                'level_id'         => $khmerG1,
                'academic_year_id' => $currentYear->id,
                'shift_id'         => $morningShift?->id,
                'teacher_id'       => $teacher002,
                'room_id'          => $classroomA201,
                'branch_id'        => $mainBranchId,
                'start_date'       => $currentYear->start_date,
                'end_date'         => $currentYear->end_date,
                'status'           => 'active',
            ],
            [
                'class_code'       => 'MTH-BAS-EVE-' . $currentYear->name,
                'course_id'        => $mathCourse,
                'level_id'         => $mathBasic,
                'academic_year_id' => $currentYear->id,
                'shift_id'         => $eveningShift?->id,
                'teacher_id'       => $teacher003,
                'room_id'          => $classroomC101,
                'branch_id'        => $mainBranchId,
                'start_date'       => $currentYear->start_date,
                'end_date'         => $currentYear->end_date,
                'status'           => 'active',
            ],
            [
                'class_code'       => 'CS-FND-WKD-' . $currentYear->name,
                'course_id'        => $csCourse,
                'level_id'         => $csLevel,
                'academic_year_id' => $currentYear->id,
                'shift_id'         => $weekendShift?->id,
                'teacher_id'       => $teacher004,
                'room_id'          => null,
                'branch_id'        => $mainBranchId,
                'start_date'       => $currentYear->start_date,
                'end_date'         => $currentYear->end_date,
                'status'           => 'active',
            ],
            [
                'class_code'       => 'CHN-HSK1-AFT-' . $currentYear->name,
                'course_id'        => $chineseCourse,
                'level_id'         => $hsk1Level,
                'academic_year_id' => $currentYear->id,
                'shift_id'         => $afternoonShift?->id,
                'teacher_id'       => $teacher005,
                'room_id'          => null,
                'branch_id'        => $mainBranchId,
                'start_date'       => $currentYear->start_date,
                'end_date'         => $currentYear->end_date,
                'status'           => 'active',
            ],
        ];

        foreach ($classes as $class) {
            DB::table('classes')->insertOrIgnore(
                $class + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
