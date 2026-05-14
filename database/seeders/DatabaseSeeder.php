<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Run order matters — seeders that depend on other tables must come after.
     */
    public function run(): void
    {
        $this->call([
            // 0. Branches (must be first — users.branch_id references branches)
            BranchSeeder::class,

            // 1. Roles & permissions (no dependencies)
            RolesPermissionsSeeder::class,

            // 2. Users + role assignments + branch_user pivot (needs branches, roles)
            UsersSeeder::class,

            // 3. Reference / lookup data (no dependencies)
            BasicDataSeeder::class,
            GendersSeeder::class,

            // 4. Location data (provinces → districts → communes → villages)
            ProvincesTableSeeder::class,
            DistrictsTableSeeder::class,
            CommunesTableSeeder::class,
            VillagesTableSeeder::class,

            // 5. Courses + levels
            CoursesSeeder::class,

            // 6. Academic years + shifts
            AcademicYearsShiftsSeeder::class,

            // 7. Buildings + rooms
            BuildingsRoomsSeeder::class,

            // 8. Staff (needs genders, users)
            StaffSeeder::class,

            // 9. Classes (needs courses, levels, academic_years, shifts, staff, rooms)
            ClassesSeeder::class,

            // 10. Fee types
            FeeTypesSeeder::class,

            // 11. Print templates (needs users for created_by)
            PrintTemplatesSeeder::class,

            // 12. Sample students + enrollments (needs genders, provinces, classes, academic_years)
            StudentsSeeder::class,

            // 13. Guardians linked to students
            GuardiansSeeder::class,

            // 14. Class schedules (needs classes)
            ClassSchedulesSeeder::class,

            // 15. Student room assignments (needs students, rooms)
            StudentRoomAssignmentsSeeder::class,

            // 16. Student cards (needs students, print_templates)
            StudentCardsSeeder::class,

            // 17. Student certificates (needs students, classes, enrollments, print_templates)
            StudentCertificatesSeeder::class,

            // 18. Student diplomas (needs students, courses, levels, classes, enrollments, print_templates)
            StudentDiplomasSeeder::class,

            // 19. Invoices, invoice items, payments (needs students, fee_types)
            StudentInvoicesSeeder::class,

            // 20. File protection rules (needs roles)
            FileProtectionRulesSeeder::class,

            // 21. Student files (needs students)
            StudentFilesSeeder::class,

            // 22. Student update requests (needs students, users)
            StudentUpdateRequestsSeeder::class,

            // 23. Branch settings (needs branches)
            BranchSettingSeeder::class,

            // 24. Attendance sample data (needs classes, enrollments, students)
            AttendanceSeeder::class,
        ]);
    }
}
