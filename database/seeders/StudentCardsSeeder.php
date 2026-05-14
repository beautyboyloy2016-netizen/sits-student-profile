<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentCardsSeeder extends Seeder
{
    public function run(): void
    {
        $adminId   = DB::table('users')->where('email', 'superadmin@school.edu.kh')->value('id');
        $templateId = DB::table('print_templates')
            ->where('template_type', 'student_card')
            ->where('is_default', true)
            ->value('id');

        $activeStudents = DB::table('students')->where('status', 'active')->get();

        foreach ($activeStudents as $student) {
            $exists = DB::table('student_cards')
                ->where('student_id', $student->id)
                ->where('status', 'active')
                ->exists();

            if ($exists) {
                continue;
            }

            $issueDate  = now()->toDateString();
            $expireDate = now()->addYear()->toDateString();
            $cardNo     = 'CARD-' . strtoupper(Str::random(8));

            DB::table('student_cards')->insert([
                'student_id'  => $student->id,
                'template_id' => $templateId,
                'card_no'     => $cardNo,
                'issue_date'  => $issueDate,
                'expire_date' => $expireDate,
                'qr_code'     => $student->student_code,
                'barcode'     => $student->student_code,
                'status'      => 'active',
                'issued_by'   => $adminId,
                'printed_at'  => now(),
                'print_count' => 1,
                'created_by'  => $adminId,
                'updated_by'  => $adminId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
