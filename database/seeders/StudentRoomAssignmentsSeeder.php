<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentRoomAssignmentsSeeder extends Seeder
{
    public function run(): void
    {
        // Assign some active students to residential rooms (B-block)
        $residentialRooms = DB::table('rooms')
            ->whereIn('room_type', ['single', 'double', 'shared'])
            ->where('status', 'available')
            ->get();

        if ($residentialRooms->isEmpty()) {
            return;
        }

        // Pick a few active students to assign
        $studentCodes = [
            'STU-2025-003', // Siem Reap student — likely needs accommodation
            'STU-2025-005', // Battambang
            'STU-2025-011', // Battambang
            'STU-2025-018', // Battambang
        ];

        $roomIterator = $residentialRooms->getIterator();

        foreach ($studentCodes as $code) {
            $studentId = DB::table('students')->where('student_code', $code)->value('id');
            if (!$studentId) {
                continue;
            }

            // Already assigned?
            $alreadyAssigned = DB::table('student_room_assignments')
                ->where('student_id', $studentId)
                ->where('status', 'active')
                ->exists();

            if ($alreadyAssigned) {
                continue;
            }

            // Get next available room
            if (!$roomIterator->valid()) {
                break;
            }
            $room = $roomIterator->current();
            $roomIterator->next();

            DB::table('student_room_assignments')->insert([
                'student_id'    => $studentId,
                'room_id'       => $room->id,
                'check_in_date' => now()->startOfMonth()->toDateString(),
                'check_out_date'=> null,
                'status'        => 'active',
                'note'          => null,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
