<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchSetting;
use Illuminate\Database\Seeder;

class BranchSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'MAIN' => [
                'school_name_kh'           => 'សាលាបណ្ដុះបណ្ដាល មេ',
                'school_name_en'           => 'Main Training School',
                'ministry_registration_no' => 'MoEYS-MAIN-0001',
                'address'                  => 'ភ្នំពេញ, កម្ពុជា',
                'email'                    => 'main@sits.edu.kh',
            ],
            'BRA' => [
                'school_name_kh'           => 'សាលាបណ្ដុះបណ្ដាល សាខា A',
                'school_name_en'           => 'Branch A Training School',
                'ministry_registration_no' => 'MoEYS-BRA-0002',
                'address'                  => 'សៀមរាប, កម្ពុជា',
                'email'                    => 'branch-a@sits.edu.kh',
            ],
            'BRB' => [
                'school_name_kh'           => 'សាលាបណ្ដុះបណ្ដាល សាខា B',
                'school_name_en'           => 'Branch B Training School',
                'ministry_registration_no' => 'MoEYS-BRB-0003',
                'address'                  => 'បាត់ដំបង, កម្ពុជា',
                'email'                    => 'branch-b@sits.edu.kh',
            ],
        ];

        foreach ($defaults as $code => $data) {
            $branch = Branch::where('code', $code)->first();
            if (!$branch) continue;

            BranchSetting::updateOrCreate(
                ['branch_id' => $branch->id],
                $data
            );
        }
    }
}
