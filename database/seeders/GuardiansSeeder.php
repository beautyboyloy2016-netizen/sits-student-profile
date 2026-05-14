<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardiansSeeder extends Seeder
{
    public function run(): void
    {
        // Map: student_code => [guardian data...]
        // Each entry is [name_kh, name_en, phone, occupation, relationship]
        $data = [
            'STU-2025-001' => [['name_kh'=>'សុខ ស្រីម',      'name_en'=>'Sok Sreyma',      'phone'=>'0130000001','occupation'=>'Merchant',    'relationship'=>'Mother']],
            'STU-2025-002' => [['name_kh'=>'ចាន់ ប៊ុនថន',    'name_en'=>'Chan Bunthon',    'phone'=>'0130000002','occupation'=>'Farmer',      'relationship'=>'Father']],
            'STU-2025-003' => [['name_kh'=>'ហេង ស្រីណារ',    'name_en'=>'Heng Sreynar',    'phone'=>'0130000003','occupation'=>'Teacher',     'relationship'=>'Mother']],
            'STU-2025-004' => [['name_kh'=>'លី ចន្ទ',         'name_en'=>'Ly Chan',         'phone'=>'0130000004','occupation'=>'Civil Servant','relationship'=>'Father']],
            'STU-2025-005' => [['name_kh'=>'គង់ ស្រីលាភ',    'name_en'=>'Kong Sreyliap',   'phone'=>'0130000005','occupation'=>'Merchant',    'relationship'=>'Mother']],
            'STU-2025-006' => [['name_kh'=>'ភ័ក្ដី ស្រីរ័ត្ន','name_en'=>'Phakdey Srey Roth','phone'=>'0130000006','occupation'=>'Nurse',     'relationship'=>'Mother']],
            'STU-2025-007' => [['name_kh'=>'ទេព ចន្ទ',        'name_en'=>'Tep Chan',        'phone'=>'0130000007','occupation'=>'Farmer',      'relationship'=>'Father']],
            'STU-2025-008' => [['name_kh'=>'ន ស្រីម',         'name_en'=>'Noun Sreyma',     'phone'=>'0130000008','occupation'=>'Merchant',    'relationship'=>'Mother']],
            'STU-2025-009' => [['name_kh'=>'ម៉ៅ ម៉ានិត',      'name_en'=>'Mao Manit',       'phone'=>'0130000009','occupation'=>'Driver',      'relationship'=>'Father']],
            'STU-2025-010' => [['name_kh'=>'វ៉ាន់ ស្រីរ',    'name_en'=>'Van Srey',        'phone'=>'0130000010','occupation'=>'Housewife',   'relationship'=>'Mother']],
            'STU-2025-011' => [['name_kh'=>'ពន្លឺ ស្រីណារ',  'name_en'=>'Ponleu Sreynar',  'phone'=>'0130000011','occupation'=>'Merchant',    'relationship'=>'Mother']],
            'STU-2025-012' => [['name_kh'=>'សៀង ចន្ទ',        'name_en'=>'Seang Chan',      'phone'=>'0130000012','occupation'=>'Soldier',     'relationship'=>'Father']],
            'STU-2025-013' => [['name_kh'=>'ឈីម ស្រីណារ',    'name_en'=>'Chhim Sreynar',   'phone'=>'0130000013','occupation'=>'Teacher',     'relationship'=>'Mother']],
            'STU-2025-014' => [['name_kh'=>'ប៉ែន ស្រីម',     'name_en'=>'Pen Sreyma',      'phone'=>'0130000014','occupation'=>'Farmer',      'relationship'=>'Mother']],
            'STU-2025-015' => [['name_kh'=>'ស្រស់ ចន្ទ',      'name_en'=>'Sros Chan',       'phone'=>'0130000015','occupation'=>'Civil Servant','relationship'=>'Father']],
            'STU-2025-016' => [['name_kh'=>'ជា ស្រីណា',       'name_en'=>'Chea Sreyna',     'phone'=>'0130000016','occupation'=>'Merchant',    'relationship'=>'Mother']],
            'STU-2025-017' => [['name_kh'=>'ថន ចន្ទ',         'name_en'=>'Thon Chan',       'phone'=>'0130000017','occupation'=>'Farmer',      'relationship'=>'Father']],
            'STU-2025-018' => [['name_kh'=>'ឡុង ស្រីម',      'name_en'=>'Long Sreyma',     'phone'=>'0130000018','occupation'=>'Nurse',       'relationship'=>'Mother']],
            'STU-2025-019' => [['name_kh'=>'ហ៊ុន ចន្ទ',       'name_en'=>'Hun Chan',        'phone'=>'0130000019','occupation'=>'Merchant',    'relationship'=>'Father']],
            'STU-2025-020' => [['name_kh'=>'ប៊ុន ស្រីណារ',   'name_en'=>'Bun Sreynar',     'phone'=>'0130000020','occupation'=>'Teacher',     'relationship'=>'Mother']],
            'STU-2024-001' => [['name_kh'=>'ស៊ីម ចន្ទ',       'name_en'=>'Sim Chan',        'phone'=>'0130000021','occupation'=>'Farmer',      'relationship'=>'Father']],
            'STU-2024-002' => [['name_kh'=>'ទូច ស្រីម',       'name_en'=>'Touch Sreyma',    'phone'=>'0130000022','occupation'=>'Merchant',    'relationship'=>'Mother']],
            'STU-2024-003' => [['name_kh'=>'ម៉ស់ ចន្ទ',       'name_en'=>'Mos Chan',        'phone'=>'0130000023','occupation'=>'Driver',      'relationship'=>'Father']],
            'STU-2024-004' => [['name_kh'=>'រ៉ាំ ចន្ទ',       'name_en'=>'Ram Chan',        'phone'=>'0130000024','occupation'=>'Farmer',      'relationship'=>'Father']],
            'STU-2024-005' => [['name_kh'=>'ហាក់ ស្រីម',      'name_en'=>'Hak Sreyma',      'phone'=>'0130000025','occupation'=>'Housewife',   'relationship'=>'Mother']],
        ];

        foreach ($data as $studentCode => $guardians) {
            $studentId = DB::table('students')->where('student_code', $studentCode)->value('id');
            if (!$studentId) {
                continue;
            }

            foreach ($guardians as $index => $g) {
                $guardianId = DB::table('guardians')->insertGetId([
                    'name_kh'    => $g['name_kh'],
                    'name_en'    => $g['name_en'],
                    'phone'      => $g['phone'],
                    'occupation' => $g['occupation'],
                    'address_id' => null,
                    'note'       => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('student_guardians')->insertOrIgnore([
                    'student_id'   => $studentId,
                    'guardian_id'  => $guardianId,
                    'relationship' => $g['relationship'],
                    'is_primary'   => $index === 0 ? true : false,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
    }
}
