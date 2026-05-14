<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileProtectionRulesSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = DB::table('roles')->where('name', 'super_admin')->value('id');
        $adminRole = DB::table('roles')->where('name', 'admin')->value('id');
        $teacherRole = DB::table('roles')->where('name', 'teacher')->value('id');

        $rules = [
            // Super Admin — full access to everything
            [
                'name' => 'Super Admin — Full Access',
                'module' => null,
                'allow_download' => true,
                'allow_print' => true,
                'allow_export' => true,
                'watermark_enabled' => false,
                'role_id' => $superAdminRole,
            ],
            // Admin — can print & export with watermark off
            [
                'name' => 'Admin — Student Cards',
                'module' => 'student_card',
                'allow_download' => true,
                'allow_print' => true,
                'allow_export' => true,
                'watermark_enabled' => false,
                'role_id' => $adminRole,
            ],
            [
                'name' => 'Admin — Certificates',
                'module' => 'certificate',
                'allow_download' => true,
                'allow_print' => true,
                'allow_export' => true,
                'watermark_enabled' => false,
                'role_id' => $adminRole,
            ],
            [
                'name' => 'Admin — Diplomas',
                'module' => 'diploma',
                'allow_download' => true,
                'allow_print' => true,
                'allow_export' => true,
                'watermark_enabled' => false,
                'role_id' => $adminRole,
            ],
            [
                'name' => 'Admin — Student Files',
                'module' => 'student_files',
                'allow_download' => true,
                'allow_print' => false,
                'allow_export' => true,
                'watermark_enabled' => true,
                'role_id' => $adminRole,
            ],
            // Teacher - view only, watermarked
            [
                'name' => 'Teacher - Student Cards View',
                'module' => 'student_card',
                'allow_download' => false,
                'allow_print' => false,
                'allow_export' => false,
                'watermark_enabled' => true,
                'role_id' => $teacherRole,
            ],
            [
                'name' => 'Teacher - Student Files View',
                'module' => 'student_files',
                'allow_download' => false,
                'allow_print' => false,
                'allow_export' => false,
                'watermark_enabled' => true,
                'role_id' => $teacherRole,
            ],
        ];

        foreach ($rules as $rule) {
            $exists = DB::table('file_protection_rules')
                ->where('name', $rule['name'])
                ->exists();

            if (! $exists) {
                DB::table('file_protection_rules')->insert(
                    $rule + ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
