<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Resolve branch IDs by code (branches must already be seeded)
        $branches = DB::table('branches')->pluck('id', 'code');

        $mainId = $branches['MAIN'] ?? null;
        $braId  = $branches['BRA']  ?? null;
        $brbId  = $branches['BRB']  ?? null;
        $brcId  = $branches['BRC']  ?? null;
        $brdId  = $branches['BRD']  ?? null;

        /**
         * Each entry:
         *   branch_id  — the user's default / primary branch
         *   branches   — all branches this user can access (pivot)
         */
        $users = [
            [
                'name'      => 'Super Admin',
                'email'     => 'superadmin@school.edu.kh',
                'phone'     => '0100000001',
                'password'  => Hash::make('password'),
                'status'    => 'active',
                'role'      => 'super_admin',
                'branch_id' => $mainId,                                     // default branch
                'branches'  => array_values(array_filter([$mainId, $braId, $brbId, $brcId, $brdId])), // all branches
            ],
            [
                'name'      => 'Admin',
                'email'     => 'admin@school.edu.kh',
                'phone'     => '0100000002',
                'password'  => Hash::make('password'),
                'status'    => 'active',
                'role'      => 'admin',
                'branch_id' => $mainId,
                'branches'  => array_values(array_filter([$mainId, $braId])),
            ],
            [
                'name'      => 'Teacher Demo',
                'email'     => 'teacher@school.edu.kh',
                'phone'     => '0100000003',
                'password'  => Hash::make('password'),
                'status'    => 'active',
                'role'      => 'teacher',
                'branch_id' => $brbId,
                'branches'  => array_values(array_filter([$brbId])),
            ],
            [
                'name'      => 'Receptionist Demo',
                'email'     => 'receptionist@school.edu.kh',
                'phone'     => '0100000004',
                'password'  => Hash::make('password'),
                'status'    => 'active',
                'role'      => 'receptionist',
                'branch_id' => $brcId,
                'branches'  => array_values(array_filter([$brcId])),
            ],
            [
                'name'      => 'Accountant Demo',
                'email'     => 'accountant@school.edu.kh',
                'phone'     => '0100000005',
                'password'  => Hash::make('password'),
                'status'    => 'active',
                'role'      => 'accountant',
                'branch_id' => $brdId,
                'branches'  => array_values(array_filter([$mainId, $brdId])),
            ],
        ];

        foreach ($users as $data) {
            $roleName       = $data['role'];
            $branchIds      = $data['branches'];
            $defaultBranch  = $data['branch_id'];
            unset($data['role'], $data['branches']);

            // Insert or update user (with branch_id)
            $userId = DB::table('users')->where('email', $data['email'])->value('id');
            if (!$userId) {
                $userId = DB::table('users')->insertGetId(
                    $data + ['created_at' => now(), 'updated_at' => now()]
                );
            } else {
                // Ensure branch_id is set on existing rows
                DB::table('users')->where('id', $userId)->update([
                    'branch_id'  => $defaultBranch,
                    'updated_at' => now(),
                ]);
            }

            // Assign role
            $role = DB::table('roles')->where('name', $roleName)->first();
            if ($role) {
                DB::table('role_user')->insertOrIgnore([
                    'user_id'    => $userId,
                    'role_id'    => $role->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Populate branch_user pivot
            foreach ($branchIds as $branchId) {
                DB::table('branch_user')->insertOrIgnore([
                    'branch_id' => $branchId,
                    'user_id'   => $userId,
                ]);
            }
        }
    }
}
