<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles ────────────────────────────────────────────────────────
        $roles = [
            ['name' => 'super_admin',   'display_name' => 'Super Admin',   'description' => 'Full system access'],
            ['name' => 'admin',         'display_name' => 'Admin',         'description' => 'Administrative access'],
            ['name' => 'teacher',       'display_name' => 'Teacher',       'description' => 'Teacher / Instructor'],
            ['name' => 'receptionist',  'display_name' => 'Receptionist',  'description' => 'Front-desk staff'],
            ['name' => 'accountant',    'display_name' => 'Accountant',    'description' => 'Finance & payment access'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insertOrIgnore($role + ['created_at' => now(), 'updated_at' => now()]);
        }

        // ── Permissions ──────────────────────────────────────────────────
        $modules = [
            // Core People
            'students'                 => ['view', 'create', 'edit', 'delete', 'export'],
            'guardians'                => ['view', 'create', 'edit', 'delete'],
            'staff'                    => ['view', 'create', 'edit', 'delete'],
            'student_files'            => ['view', 'create', 'edit', 'delete'],
            'student_room_assignments' => ['view', 'create', 'edit', 'delete'],
            'student_update_requests'  => ['view', 'create', 'approve', 'delete'],

            // Academic
            'enrollments'              => ['view', 'create', 'edit', 'delete'],
            'courses'                  => ['view', 'create', 'edit', 'delete'],
            'classes'                  => ['view', 'create', 'edit', 'delete'],
            'academic_years'           => ['view', 'create', 'edit', 'delete'],
            'shifts'                   => ['view', 'create', 'edit', 'delete'],
            'attendances'              => ['view', 'create', 'edit', 'delete', 'export'],

            // Facilities
            'rooms'                    => ['view', 'create', 'edit', 'delete'],

            // Finance
            'payments'                 => ['view', 'create', 'edit', 'delete', 'export'],
            'invoices'                 => ['view', 'create', 'edit', 'delete'],
            'fee_types'                => ['view', 'create', 'edit', 'delete'],

            // Print & Documents
            'print_templates'          => ['view', 'create', 'edit', 'delete'],
            'cards'                    => ['view', 'create', 'edit', 'delete', 'print'],
            'certificates'             => ['view', 'create', 'edit', 'delete', 'approve', 'print'],
            'diplomas'                 => ['view', 'create', 'edit', 'delete', 'approve', 'print'],

            // Administration
            'branches'                 => ['view', 'create', 'edit', 'delete', 'switch'],
            'branch_settings'          => ['view', 'edit'],
            'users'                    => ['view', 'create', 'edit', 'delete'],
            'roles'                    => ['view', 'create', 'edit', 'delete'],
            'permissions'              => ['view', 'create', 'edit', 'delete'],

            // Settings
            'genders'                  => ['view', 'create', 'edit', 'delete'],
            'locations'                => ['view', 'create', 'edit', 'delete'],
            'file_protection_rules'    => ['view', 'create', 'edit', 'delete'],

            // Logs
            'audit_logs'               => ['view'],
            'report_logs'              => ['view', 'create', 'export'],
            'export_logs'              => ['view'],
            'print_logs'               => ['view'],
            'file_access_logs'         => ['view'],

            // Reports
            'reports'                  => ['view', 'export'],

            // General Settings
            'settings'                 => ['view', 'edit'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $name = "{$module}.{$action}";
                DB::table('permissions')->insertOrIgnore([
                    'name'         => $name,
                    'module'       => $module,
                    'display_name' => ucfirst($action) . ' ' . ucfirst($module),
                    'description'  => null,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        // ── Assign ALL permissions to super_admin (full control) ─────────
        // Idempotent: removes stale entries (in case a permission was renamed/deleted)
        // then re-attaches every current permission. Guarantees super_admin always
        // has full system access after each seed run.
        $superAdminRole = DB::table('roles')->where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $allPermissions = DB::table('permissions')->pluck('id');

            // Clean slate for super_admin pivot rows
            DB::table('permission_role')->where('role_id', $superAdminRole->id)->delete();

            $rows = [];
            foreach ($allPermissions as $permId) {
                $rows[] = [
                    'permission_id' => $permId,
                    'role_id'       => $superAdminRole->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
            if (!empty($rows)) {
                DB::table('permission_role')->insert($rows);
            }
        }

        // ── Assign limited permissions to admin ──────────────────────────
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        if ($adminRole) {
            $adminModules = [
                'students', 'guardians', 'staff',
                'student_files', 'student_room_assignments', 'student_update_requests',
                'enrollments', 'courses', 'classes', 'academic_years', 'shifts',
                'attendances', 'rooms',
                'payments', 'invoices', 'fee_types',
                'print_templates', 'cards', 'certificates', 'diplomas',
                'reports', 'branch_settings',
                'audit_logs', 'report_logs', 'export_logs', 'print_logs', 'file_access_logs',
            ];
            $adminPermissions = DB::table('permissions')
                ->whereIn('module', $adminModules)
                ->pluck('id');
            foreach ($adminPermissions as $permId) {
                DB::table('permission_role')->insertOrIgnore([
                    'permission_id' => $permId,
                    'role_id'       => $adminRole->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        // ── Per-role granular permissions (teacher, receptionist, accountant) ──
        // Format: role_name => [ module => [actions...] ]
        $rolePermissionMap = [

            // Teacher: focused on classes, students, attendance
            'teacher' => [
                'students'                 => ['view'],
                'guardians'                => ['view'],
                'enrollments'              => ['view'],
                'courses'                  => ['view'],
                'classes'                  => ['view'],
                'academic_years'           => ['view'],
                'shifts'                   => ['view'],
                'attendances'              => ['view', 'create', 'edit', 'export'],
                'student_files'            => ['view'],
                'student_room_assignments' => ['view'],
                'certificates'             => ['view'],
                'diplomas'                 => ['view'],
                'cards'                    => ['view'],
                'reports'                  => ['view'],
            ],

            // Receptionist: front-desk — registration, guardian/student intake, cards
            'receptionist' => [
                'students'                 => ['view', 'create', 'edit'],
                'guardians'                => ['view', 'create', 'edit'],
                'enrollments'              => ['view', 'create', 'edit'],
                'courses'                  => ['view'],
                'classes'                  => ['view'],
                'academic_years'           => ['view'],
                'shifts'                   => ['view'],
                'rooms'                    => ['view'],
                'attendances'              => ['view'],
                'student_files'            => ['view', 'create', 'edit'],
                'student_room_assignments' => ['view', 'create', 'edit'],
                'student_update_requests'  => ['view', 'create'],
                'cards'                    => ['view', 'create', 'print'],
                'certificates'             => ['view'],
                'diplomas'                 => ['view'],
                'invoices'                 => ['view'],
                'payments'                 => ['view'],
            ],

            // Accountant: finance / billing only
            'accountant' => [
                'students'                 => ['view'],
                'guardians'                => ['view'],
                'enrollments'              => ['view'],
                'courses'                  => ['view'],
                'classes'                  => ['view'],
                'academic_years'           => ['view'],
                'fee_types'                => ['view', 'create', 'edit'],
                'invoices'                 => ['view', 'create', 'edit'],
                'payments'                 => ['view', 'create', 'edit', 'export'],
                'reports'                  => ['view', 'export'],
                'report_logs'              => ['view', 'create', 'export'],
                'export_logs'              => ['view'],
            ],
        ];

        foreach ($rolePermissionMap as $roleName => $modules) {
            $role = DB::table('roles')->where('name', $roleName)->first();
            if (!$role) {
                continue;
            }

            // Build the desired list of permission names for this role
            $permNames = [];
            foreach ($modules as $module => $actions) {
                foreach ($actions as $action) {
                    $permNames[] = "{$module}.{$action}";
                }
            }

            $permissionIds = DB::table('permissions')
                ->whereIn('name', $permNames)
                ->pluck('id');

            foreach ($permissionIds as $permId) {
                DB::table('permission_role')->insertOrIgnore([
                    'permission_id' => $permId,
                    'role_id'       => $role->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
