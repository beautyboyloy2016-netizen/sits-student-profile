<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Room;
use App\Models\StudentRoomAssignment;
use App\Http\Requests\StudentRoomAssignment\StoreStudentRoomAssignmentRequest;
use App\Http\Requests\StudentRoomAssignment\UpdateStudentRoomAssignmentRequest;
use Illuminate\Http\Request;

class StudentRoomAssignmentController extends Controller
{
    public function globalIndex()
    {
        $assignments = \App\Models\StudentRoomAssignment::with('student', 'room.building')->latest()->paginate(50);
        return view('admin.student_room_assignments.global_index', compact('assignments'));
    }

    public function index(Student $student)
    {
        $student->load('roomAssignments.room.building');
        $rooms = Room::where('status', 'available')->with('building')->get();
        return view('admin.student_room_assignments.index', compact('student', 'rooms'));
    }

    public function store(StoreStudentRoomAssignmentRequest $request, Student $student)
    {
        StudentRoomAssignment::create([
            'student_id'    => $student->id,
            'room_id'       => $request->room_id,
            'check_in_date' => $request->check_in_date ?? now(),
            'status'        => 'active',
            'note'          => $request->note ?? null,
        ]);

        flash()->success('Room assigned successfully.');
        return redirect()->route('students.room-assignments.index', $student);
    }

    public function update(UpdateStudentRoomAssignmentRequest $request, Student $student, StudentRoomAssignment $assignment)
    {
        if ($assignment->student_id !== $student->id) {
            abort(403);
        }
        $assignment->update([
            'room_id'        => $request->room_id ?? $assignment->room_id,
            'check_in_date'  => $request->check_in_date ?? $assignment->check_in_date,
            'check_out_date' => $request->check_out_date ?? $assignment->check_out_date,
            'status'         => $request->status ?? $assignment->status,
            'note'           => $request->note ?? $assignment->note,
        ]);
        flash()->success('Room assignment updated successfully.');
        return redirect()->route('students.room-assignments.index', $student);
    }

    public function destroy(Student $student, StudentRoomAssignment $assignment)
    {
        if ($assignment->student_id !== $student->id) {
            abort(403);
        }
        $assignment->update(['status' => 'checked_out', 'check_out_date' => now()]);
        flash()->success('Room assignment removed.');
        return redirect()->route('students.room-assignments.index', $student);
    }
}
