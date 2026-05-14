<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'code'       => 'MAIN',
                'name_kh'    => 'សាខាមេ',
                'name_en'    => 'Main Branch',
                'address'    => null,
                'phone'      => null,
                'email'      => 'main@sits.edu.kh',
                'is_main'    => true,
                'status'     => 'active',
                'sort_order' => 1,
            ],
            [
                'code'       => 'BRA',
                'name_kh'    => 'សាខា A',
                'name_en'    => 'Branch A',
                'address'    => null,
                'phone'      => null,
                'email'      => 'branch-a@sits.edu.kh',
                'is_main'    => false,
                'status'     => 'active',
                'sort_order' => 2,
            ],
            [
                'code'       => 'BRB',
                'name_kh'    => 'សាខា B',
                'name_en'    => 'Branch B',
                'address'    => null,
                'phone'      => null,
                'email'      => 'branch-b@sits.edu.kh',
                'is_main'    => false,
                'status'     => 'active',
                'sort_order' => 3,
            ],
            [
                'code'       => 'BRC',
                'name_kh'    => 'សាខា C',
                'name_en'    => 'Branch C',
                'address'    => null,
                'phone'      => null,
                'email'      => 'branch-c@sits.edu.kh',
                'is_main'    => false,
                'status'     => 'active',
                'sort_order' => 4,
            ],
            [
                'code'       => 'BRD',
                'name_kh'    => 'សាខា D',
                'name_en'    => 'Branch D',
                'address'    => null,
                'phone'      => null,
                'email'      => 'branch-d@sits.edu.kh',
                'is_main'    => false,
                'status'     => 'active',
                'sort_order' => 5,
            ],
        ];

        foreach ($branches as $data) {
            Branch::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}
