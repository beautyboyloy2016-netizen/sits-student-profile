<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsSeeder extends Seeder
{
    public function run(): void
    {
        $adminId  = DB::table('users')->where('email', 'superadmin@school.edu.kh')->value('id');
        $maleId   = DB::table('genders')->where('name_en', 'Male')->value('id');
        $femaleId = DB::table('genders')->where('name_en', 'Female')->value('id');
        $mainBranchId = DB::table('branches')->where('is_main', true)->value('id');

        $phnomPenhId   = DB::table('provinces')->where('name_en', 'Phnom Penh')->value('id');
        $sieamReapId   = DB::table('provinces')->where('name_en', 'Siemreap')->value('id');
        $battambangId  = DB::table('provinces')->where('name_en', 'Battambang')->value('id');
        $kandalId      = DB::table('provinces')->where('name_en', 'Kandal')->value('id');
        $kampongChamId = DB::table('provinces')->where('name_en', 'Kampong Cham')->value('id');

        // Current academic year & classes
        $currentYear  = DB::table('academic_years')->where('is_current', true)->first();
        $engBegClass  = DB::table('classes')->where('class_code', 'like', 'ENG-BEG%')->first();
        $engIntClass  = DB::table('classes')->where('class_code', 'like', 'ENG-INT%')->first();
        $mathClass    = DB::table('classes')->where('class_code', 'like', 'MTH-%')->first();
        $csClass      = DB::table('classes')->where('class_code', 'like', 'CS-%')->first();
        $chineseClass = DB::table('classes')->where('class_code', 'like', 'CHN-%')->first();
        $khmerClass   = DB::table('classes')->where('class_code', 'like', 'KHM-%')->first();

        // [student_data, province_id, class_to_enroll]
        $students = [
            // ── 2025 Active ───────────────────────────────────────────────
            ['student_code'=>'STU-2025-001','khmer_name'=>'សុខ លក្ខណ៍',      'latin_name'=>'Sok Leak',          'gender_id'=>$maleId,   'date_of_birth'=>'2005-03-15','phone'=>'0120000001','email'=>'sokleak@example.com',      'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$engBegClass],
            ['student_code'=>'STU-2025-002','khmer_name'=>'ចាន់ សុភា',        'latin_name'=>'Chan Sopheap',      'gender_id'=>$femaleId, 'date_of_birth'=>'2006-07-22','phone'=>'0120000002','email'=>'chansopheap@example.com',  'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$engBegClass],
            ['student_code'=>'STU-2025-003','khmer_name'=>'ហេង វណ្ណៈ',        'latin_name'=>'Heng Vanna',        'gender_id'=>$maleId,   'date_of_birth'=>'2004-11-08','phone'=>'0120000003','email'=>null,                       'status'=>'active',   'province_id'=>$sieamReapId,   'class'=>$engBegClass],
            ['student_code'=>'STU-2025-004','khmer_name'=>'លី ស្រីណា',        'latin_name'=>'Ly Sreyna',         'gender_id'=>$femaleId, 'date_of_birth'=>'2005-01-30','phone'=>'0120000004','email'=>null,                       'status'=>'active',   'province_id'=>$kandalId,      'class'=>$mathClass],
            ['student_code'=>'STU-2025-005','khmer_name'=>'គង់ ដារ៉ា',        'latin_name'=>'Kong Dara',         'gender_id'=>$maleId,   'date_of_birth'=>'2003-09-12','phone'=>'0120000005','email'=>'kongdara@example.com',     'status'=>'active',   'province_id'=>$battambangId,  'class'=>$engIntClass],
            ['student_code'=>'STU-2025-006','khmer_name'=>'ភ័ក្ដី រតនា',      'latin_name'=>'Phakdey Ratana',    'gender_id'=>$maleId,   'date_of_birth'=>'2004-05-19','phone'=>'0120000006','email'=>null,                       'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$csClass],
            ['student_code'=>'STU-2025-007','khmer_name'=>'ទេព ស្រីពៅ',       'latin_name'=>'Tep Sreypov',       'gender_id'=>$femaleId, 'date_of_birth'=>'2005-08-04','phone'=>'0120000007','email'=>'tepsreypov@example.com',   'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$chineseClass],
            ['student_code'=>'STU-2025-008','khmer_name'=>'ន គឹមហេង',         'latin_name'=>'Noun Kimheng',      'gender_id'=>$maleId,   'date_of_birth'=>'2006-02-17','phone'=>'0120000008','email'=>null,                       'status'=>'active',   'province_id'=>$kampongChamId, 'class'=>$engBegClass],
            ['student_code'=>'STU-2025-009','khmer_name'=>'ម៉ៅ ស្រីម៉ម',       'latin_name'=>'Mao Sreymom',       'gender_id'=>$femaleId, 'date_of_birth'=>'2005-06-11','phone'=>'0120000009','email'=>null,                       'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$khmerClass],
            ['student_code'=>'STU-2025-010','khmer_name'=>'វ៉ាន់ ច័ន្ទថា',     'latin_name'=>'Van Chantha',       'gender_id'=>$femaleId, 'date_of_birth'=>'2004-10-28','phone'=>'0120000010','email'=>'vanchantha@example.com',   'status'=>'active',   'province_id'=>$sieamReapId,   'class'=>$engIntClass],
            ['student_code'=>'STU-2025-011','khmer_name'=>'ពន្លឺ ម៉ានិត',      'latin_name'=>'Ponleu Manit',      'gender_id'=>$maleId,   'date_of_birth'=>'2003-12-03','phone'=>'0120000011','email'=>null,                       'status'=>'active',   'province_id'=>$battambangId,  'class'=>$mathClass],
            ['student_code'=>'STU-2025-012','khmer_name'=>'សៀង វិចិត្រ',       'latin_name'=>'Seang Vichit',      'gender_id'=>$maleId,   'date_of_birth'=>'2005-04-14','phone'=>'0120000012','email'=>'seangvichit@example.com',  'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$csClass],
            ['student_code'=>'STU-2025-013','khmer_name'=>'ឈីម ស្រីលក្ខណ៍',   'latin_name'=>'Chhim Sreyleak',    'gender_id'=>$femaleId, 'date_of_birth'=>'2006-09-20','phone'=>'0120000013','email'=>null,                       'status'=>'active',   'province_id'=>$kandalId,        'class'=>$engBegClass],
            ['student_code'=>'STU-2025-014','khmer_name'=>'ប៉ែន វណ្ណឌី',       'latin_name'=>'Pen Vanndy',        'gender_id'=>$maleId,   'date_of_birth'=>'2004-07-07','phone'=>'0120000014','email'=>null,                       'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$chineseClass],
            ['student_code'=>'STU-2025-015','khmer_name'=>'ស្រស់ ស្រីរ័ត្ន',   'latin_name'=>'Sros Sreyroth',     'gender_id'=>$femaleId, 'date_of_birth'=>'2005-11-25','phone'=>'0120000015','email'=>'srossreyroth@example.com', 'status'=>'active',   'province_id'=>$kampongChamId, 'class'=>$mathClass],
            ['student_code'=>'STU-2025-016','khmer_name'=>'ជា សុភ័ក្ត្រ',      'latin_name'=>'Chea Sopheak',      'gender_id'=>$maleId,   'date_of_birth'=>'2003-05-31','phone'=>'0120000016','email'=>null,                       'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$engIntClass],
            ['student_code'=>'STU-2025-017','khmer_name'=>'ថន ស្រីពិសី',       'latin_name'=>'Thon Sreypisy',     'gender_id'=>$femaleId, 'date_of_birth'=>'2006-01-16','phone'=>'0120000017','email'=>null,                       'status'=>'active',   'province_id'=>$sieamReapId,   'class'=>$khmerClass],
            ['student_code'=>'STU-2025-018','khmer_name'=>'ឡុង ចន្ទបូរ៉ា',    'latin_name'=>'Long Chantboura',   'gender_id'=>$maleId,   'date_of_birth'=>'2004-08-09','phone'=>'0120000018','email'=>'longchantboura@example.com','status'=>'active',   'province_id'=>$battambangId,  'class'=>$csClass],
            ['student_code'=>'STU-2025-019','khmer_name'=>'ហ៊ុន ស្រីចន្ទ',     'latin_name'=>'Hun Srey Chan',     'gender_id'=>$femaleId, 'date_of_birth'=>'2005-03-22','phone'=>'0120000019','email'=>null,                       'status'=>'active',   'province_id'=>$phnomPenhId,   'class'=>$engBegClass],
            ['student_code'=>'STU-2025-020','khmer_name'=>'ប៊ុន ស្រីរ៉ា',      'latin_name'=>'Bun Sreyra',        'gender_id'=>$femaleId, 'date_of_birth'=>'2004-12-01','phone'=>'0120000020','email'=>'bunsreyra@example.com',    'status'=>'active',   'province_id'=>$kandalId,        'class'=>$chineseClass],
            // ── 2024 / Other statuses ─────────────────────────────────────
            ['student_code'=>'STU-2024-001','khmer_name'=>'ស៊ីម វណ្ណថា',       'latin_name'=>'Sim Vanntha',       'gender_id'=>$femaleId, 'date_of_birth'=>'2002-12-25','phone'=>'0120000021','email'=>'simvanntha@example.com',   'status'=>'graduated','province_id'=>$phnomPenhId,   'class'=>null],
            ['student_code'=>'STU-2024-002','khmer_name'=>'ទូច ប៊ុនធឿន',       'latin_name'=>'Touch Buntheoun',   'gender_id'=>$maleId,   'date_of_birth'=>'2003-04-02','phone'=>'0120000022','email'=>null,                       'status'=>'inactive', 'province_id'=>$sieamReapId,   'class'=>null],
            ['student_code'=>'STU-2024-003','khmer_name'=>'ម៉ស់ ស្រីបូរ៉ា',    'latin_name'=>'Mos Sreyboura',     'gender_id'=>$femaleId, 'date_of_birth'=>'2001-06-18','phone'=>'0120000023','email'=>null,                       'status'=>'graduated','province_id'=>$battambangId,  'class'=>null],
            ['student_code'=>'STU-2024-004','khmer_name'=>'រ៉ាំ ស្រីណាថ',      'latin_name'=>'Ram Sreynat',       'gender_id'=>$femaleId, 'date_of_birth'=>'2002-09-05','phone'=>'0120000024','email'=>null,                       'status'=>'dropped',  'province_id'=>$kampongChamId, 'class'=>null],
            ['student_code'=>'STU-2024-005','khmer_name'=>'ហាក់ ពិសិដ្ឋ',      'latin_name'=>'Hak Pisit',         'gender_id'=>$maleId,   'date_of_birth'=>'2003-02-14','phone'=>'0120000025','email'=>null,                       'status'=>'suspended','province_id'=>$kandalId,        'class'=>null],
        ];

        foreach ($students as $data) {
            $provinceId  = $data['province_id'];
            $classRecord = $data['class'];
            unset($data['province_id'], $data['class']);

            $birthAddressId = DB::table('addresses')->insertGetId([
                'province_id'  => $provinceId,
                'district_id'  => null,
                'commune_id'   => null,
                'village_id'   => null,
                'street'       => null,
                'house_no'     => null,
                'full_address' => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            $studentId = DB::table('students')->insertGetId($data + [
                'birth_place_id'     => $birthAddressId,
                'current_address_id' => $birthAddressId,
                'photo_path'         => null,
                'note'               => null,
                'branch_id'          => $mainBranchId,
                'created_by'         => $adminId,
                'updated_by'         => $adminId,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Enroll active students into their assigned class
            if ($data['status'] === 'active' && $classRecord && $currentYear) {
                $alreadyEnrolled = DB::table('enrollments')
                    ->where('student_id', $studentId)
                    ->where('class_id', $classRecord->id)
                    ->exists();

                if (!$alreadyEnrolled) {
                    DB::table('enrollments')->insert([
                        'student_id'       => $studentId,
                        'class_id'         => $classRecord->id,
                        'academic_year_id' => $currentYear->id,
                        'shift_id'         => $classRecord->shift_id,
                        'enroll_date'      => now()->toDateString(),
                        'status'           => 'studying',
                        'branch_id'        => $mainBranchId,
                        'created_by'       => $adminId,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]);
                }
            }
        }
    }
}
