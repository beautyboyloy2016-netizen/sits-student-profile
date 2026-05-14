<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentUpdateRequest;
use Illuminate\Database\Seeder;

class StudentUpdateRequestsSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::limit(5)->get();

        if ($students->isEmpty()) {
            return;
        }

        $samples = [
            ['field_name' => 'phone', 'old_value' => '012000001', 'new_value' => '012111111', 'reason' => 'Phone number changed', 'status' => 'pending'],
            ['field_name' => 'email', 'old_value' => 'old@example.com', 'new_value' => 'new@example.com', 'reason' => 'Email address updated', 'status' => 'approved'],
            ['field_name' => 'khmer_name', 'old_value' => 'ឈ្មោះចាស់', 'new_value' => 'ឈ្មោះថ្មី', 'reason' => 'Name correction', 'status' => 'rejected'],
        ];

        foreach ($students as $student) {
            foreach ($samples as $sample) {
                StudentUpdateRequest::create([
                    'student_id'   => $student->id,
                    'requested_by' => 1,
                    'field_name'   => $sample['field_name'],
                    'old_value'    => $sample['old_value'],
                    'new_value'    => $sample['new_value'],
                    'reason'       => $sample['reason'],
                    'status'       => $sample['status'],
                    'approved_by'  => $sample['status'] === 'approved' ? 1 : null,
                    'approved_at'  => $sample['status'] === 'approved' ? now() : null,
                ]);
            }
        }
    }
}
