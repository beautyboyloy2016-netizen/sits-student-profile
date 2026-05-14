<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $classes = ClassModel::where('status', 'active')->with('enrollments')->take(3)->get();

        if ($classes->isEmpty()) {
            return;
        }

        $statuses = ['present', 'present', 'present', 'late', 'absent', 'excused'];

        foreach ($classes as $class) {
            $enrollments = Enrollment::where('class_id', $class->id)
                ->where('status', 'studying')
                ->take(10)
                ->get();

            // Seed 5 days of attendance
            for ($i = 4; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();

                foreach ($enrollments as $enrollment) {
                    Attendance::updateOrCreate(
                        [
                            'attendable_type' => 'student',
                            'attendable_id'   => $enrollment->student_id,
                            'date'            => $date,
                        ],
                        [
                            'branch_id'      => $class->branch_id,
                            'class_id'       => $class->id,
                            'status'         => $statuses[array_rand($statuses)],
                            'check_in_time'  => '08:00',
                            'check_out_time' => '17:00',
                            'recorded_by'    => 1,
                        ]
                    );
                }
            }
        }
    }
}
