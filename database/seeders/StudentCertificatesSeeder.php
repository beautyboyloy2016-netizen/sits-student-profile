<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentCertificatesSeeder extends Seeder
{
    public function run(): void
    {
        $adminId    = DB::table('users')->where('email', 'superadmin@school.edu.kh')->value('id');
        $templateId = DB::table('print_templates')
            ->where('template_type', 'certificate')
            ->where('is_default', true)
            ->value('id');

        // Give certificates to graduated students
        $graduatedStudents = DB::table('students')->where('status', 'graduated')->get();

        $certTypes = ['completion', 'achievement'];
        $counter   = 1;

        foreach ($graduatedStudents as $student) {
            // Find their enrollment to link class
            $enrollment = DB::table('enrollments')->where('student_id', $student->id)->first();
            $classId    = $enrollment?->class_id ?? null;

            foreach ($certTypes as $type) {
                $certNo = 'CERT-' . date('Y') . '-' . str_pad($counter++, 4, '0', STR_PAD_LEFT);

                $exists = DB::table('student_certificates')
                    ->where('student_id', $student->id)
                    ->where('certificate_type', $type)
                    ->exists();

                if ($exists) {
                    continue;
                }

                DB::table('student_certificates')->insert([
                    'certificate_no'   => $certNo,
                    'student_id'       => $student->id,
                    'class_id'         => $classId,
                    'enrollment_id'    => $enrollment?->id ?? null,
                    'template_id'      => $templateId,
                    'certificate_type' => $type,
                    'title'            => match($type) {
                        'completion'  => 'Certificate of Completion',
                        'achievement' => 'Certificate of Achievement',
                        default       => 'Certificate',
                    },
                    'description'      => 'This certificate is awarded for successfully completing the program.',
                    'issue_date'       => now()->subMonths(3)->toDateString(),
                    'status'           => 'printed',
                    'approved_by'      => $adminId,
                    'approved_at'      => now()->subMonths(3),
                    'issued_by'        => $adminId,
                    'printed_at'       => now()->subMonths(3),
                    'print_count'      => 1,
                    'created_by'       => $adminId,
                    'updated_by'       => $adminId,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            // Draft certificate for active students (appreciation)
            $activeStudents = DB::table('students')->where('status', 'active')->take(5)->get();
            foreach ($activeStudents as $activeStudent) {
                $certNo = 'CERT-' . date('Y') . '-' . str_pad($counter++, 4, '0', STR_PAD_LEFT);

                $exists = DB::table('student_certificates')
                    ->where('student_id', $activeStudent->id)
                    ->where('certificate_type', 'appreciation')
                    ->exists();

                if (!$exists) {
                    DB::table('student_certificates')->insert([
                        'certificate_no'   => $certNo,
                        'student_id'       => $activeStudent->id,
                        'class_id'         => null,
                        'enrollment_id'    => null,
                        'template_id'      => $templateId,
                        'certificate_type' => 'appreciation',
                        'title'            => 'Certificate of Appreciation',
                        'description'      => 'In recognition of outstanding dedication and commitment.',
                        'issue_date'       => now()->toDateString(),
                        'status'           => 'draft',
                        'approved_by'      => null,
                        'approved_at'      => null,
                        'issued_by'        => null,
                        'printed_at'       => null,
                        'print_count'      => 0,
                        'created_by'       => $adminId,
                        'updated_by'       => $adminId,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);
                }
                break; // only one appreciation cert per run to avoid re-seeding duplicates
            }
        }
    }
}
