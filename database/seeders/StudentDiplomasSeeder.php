<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentDiplomasSeeder extends Seeder
{
    public function run(): void
    {
        $adminId    = DB::table('users')->where('email', 'superadmin@school.edu.kh')->value('id');
        $templateId = DB::table('print_templates')
            ->where('template_type', 'diploma')
            ->where('is_default', true)
            ->value('id');

        $graduatedStudents = DB::table('students')->where('status', 'graduated')->get();

        $counter = 1;

        foreach ($graduatedStudents as $student) {
            $exists = DB::table('student_diplomas')
                ->where('student_id', $student->id)
                ->exists();

            if ($exists) {
                continue;
            }

            // Find their enrollment
            $enrollment = DB::table('enrollments')->where('student_id', $student->id)->first();
            $classId    = $enrollment?->class_id ?? null;
            $courseId   = null;
            $levelId    = null;

            if ($classId) {
                $class    = DB::table('classes')->find($classId);
                $courseId = $class?->course_id;
                $levelId  = $class?->level_id;
            }

            $diplomaNo = 'DIPL-' . date('Y') . '-' . str_pad($counter++, 4, '0', STR_PAD_LEFT);

            DB::table('student_diplomas')->insert([
                'diploma_no'      => $diplomaNo,
                'student_id'      => $student->id,
                'course_id'       => $courseId,
                'level_id'        => $levelId,
                'class_id'        => $classId,
                'enrollment_id'   => $enrollment?->id ?? null,
                'template_id'     => $templateId,
                'graduation_date' => now()->subMonths(2)->toDateString(),
                'issue_date'      => now()->subMonths(2)->toDateString(),
                'grade'           => 'A',
                'gpa'             => 3.80,
                'description'     => 'Having successfully fulfilled all requirements of the program.',
                'status'          => 'printed',
                'approved_by'     => $adminId,
                'approved_at'     => now()->subMonths(2),
                'issued_by'       => $adminId,
                'printed_at'      => now()->subMonths(2),
                'print_count'     => 1,
                'created_by'      => $adminId,
                'updated_by'      => $adminId,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
