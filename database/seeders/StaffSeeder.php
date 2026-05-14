<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $maleId       = DB::table('genders')->where('name_en', 'Male')->value('id');
        $femaleId     = DB::table('genders')->where('name_en', 'Female')->value('id');
        $mainBranchId = DB::table('branches')->where('is_main', true)->value('id');

        // Link teacher user accounts if they exist
        $teacherUserId = DB::table('users')->where('email', 'teacher@school.edu.kh')->value('id');

        $staff = [
            [
                'staff_code' => 'TCH-001',
                'name_kh'    => 'សុខ ដារ៉ា',
                'name_en'    => 'Sok Dara',
                'gender_id'  => $maleId,
                'phone'      => '0110000001',
                'email'      => 'sokdara@school.edu.kh',
                'position'   => 'English Teacher',
                'status'     => 'active',
                'user_id'    => $teacherUserId,
            ],
            [
                'staff_code' => 'TCH-002',
                'name_kh'    => 'ចាន់ សុភា',
                'name_en'    => 'Chan Sopheap',
                'gender_id'  => $femaleId,
                'phone'      => '0110000002',
                'email'      => 'chansopheap@school.edu.kh',
                'position'   => 'Khmer Language Teacher',
                'status'     => 'active',
                'user_id'    => null,
            ],
            [
                'staff_code' => 'TCH-003',
                'name_kh'    => 'ហេង វណ្ណៈ',
                'name_en'    => 'Heng Vanna',
                'gender_id'  => $maleId,
                'phone'      => '0110000003',
                'email'      => 'hengvanna@school.edu.kh',
                'position'   => 'Mathematics Teacher',
                'status'     => 'active',
                'user_id'    => null,
            ],
            [
                'staff_code' => 'TCH-004',
                'name_kh'    => 'លី ស្រីមុំ',
                'name_en'    => 'Ly Srey Mom',
                'gender_id'  => $femaleId,
                'phone'      => '0110000004',
                'email'      => 'lysreymom@school.edu.kh',
                'position'   => 'Computer Science Teacher',
                'status'     => 'active',
                'user_id'    => null,
            ],
            [
                'staff_code' => 'TCH-005',
                'name_kh'    => 'គង់ ម៉ានិត',
                'name_en'    => 'Kong Manit',
                'gender_id'  => $maleId,
                'phone'      => '0110000005',
                'email'      => 'kongmanit@school.edu.kh',
                'position'   => 'Chinese Language Teacher',
                'status'     => 'active',
                'user_id'    => null,
            ],
            [
                'staff_code' => 'ADM-001',
                'name_kh'    => 'ភក្ដី រតនា',
                'name_en'    => 'Phakdey Ratana',
                'gender_id'  => $maleId,
                'phone'      => '0110000006',
                'email'      => 'phakdeyratana@school.edu.kh',
                'position'   => 'School Director',
                'status'     => 'active',
                'user_id'    => null,
            ],
        ];

        foreach ($staff as $member) {
            DB::table('staff')->insertOrIgnore(
                $member + ['branch_id' => $mainBranchId, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
