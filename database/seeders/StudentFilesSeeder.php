<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\StudentFile;
use Illuminate\Database\Seeder;

class StudentFilesSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::limit(10)->get();

        if ($students->isEmpty()) {
            return;
        }

        $fileTypes = [
            ['file_type' => 'photo',             'file_path' => 'student_files/sample_photo.jpg',      'original_name' => 'sample_photo.jpg',      'mime_type' => 'image/jpeg', 'size' => 102400, 'is_primary' => true],
            ['file_type' => 'id_card',            'file_path' => 'student_files/sample_id_card.jpg',    'original_name' => 'sample_id_card.jpg',    'mime_type' => 'image/jpeg', 'size' => 204800, 'is_primary' => false],
            ['file_type' => 'birth_certificate',  'file_path' => 'student_files/sample_birth_cert.pdf', 'original_name' => 'sample_birth_cert.pdf', 'mime_type' => 'application/pdf', 'size' => 512000, 'is_primary' => false],
        ];

        foreach ($students as $student) {
            foreach ($fileTypes as $fileData) {
                StudentFile::create([
                    'student_id'    => $student->id,
                    'file_type'     => $fileData['file_type'],
                    'file_path'     => $fileData['file_path'],
                    'original_name' => $fileData['original_name'],
                    'mime_type'     => $fileData['mime_type'],
                    'size'          => $fileData['size'],
                    'is_primary'    => $fileData['is_primary'],
                    'uploaded_by'   => 1,
                ]);
            }
        }
    }
}
