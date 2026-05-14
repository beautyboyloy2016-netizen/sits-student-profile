<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentUpdateRequest;
use App\Http\Requests\StudentUpdateRequest\StoreStudentUpdateRequestRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentUpdateRequestController extends Controller
{
    public function globalIndex(Request $request)
    {
        if ($request->ajax()) {
            $query = StudentUpdateRequest::with('student', 'requester')->latest();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('student_name', fn($r) => $r->student
                    ? '<a href="' . route('students.show', $r->student) . '">' . e($r->student->khmer_name) . '</a>'
                    : '<span class="text-muted">N/A</span>')
                ->addColumn('field_label', fn($r) => e($r->field_name))
                ->addColumn('old_value_short', fn($r) => $r->old_value ? \Illuminate\Support\Str::limit($r->old_value, 40) : '—')
                ->addColumn('new_value_short', fn($r) => $r->new_value ? \Illuminate\Support\Str::limit($r->new_value, 40) : '—')
                ->addColumn('reason_short', fn($r) => $r->reason ? \Illuminate\Support\Str::limit($r->reason, 40) : '—')
                ->addColumn('requested_by_name', fn($r) => $r->requester?->name ?? '—')
                ->addColumn('status_badge', function ($r) {
                    $map = ['approved' => 'success', 'pending' => 'warning', 'rejected' => 'danger'];
                    $color = $map[$r->status] ?? 'secondary';
                    $label = __('app.' . $r->status) ?? ucfirst($r->status);
                    return '<span class="badge badge-' . $color . '">' . e($label) . '</span>';
                })
                ->addColumn('actions', fn($r) => $r->student
                    ? '<a href="' . route('students.update-requests.index', $r->student) . '" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>'
                    : '')
                ->rawColumns(['student_name', 'status_badge', 'actions'])
                ->make(true);
        }
        return view('admin.student_update_requests.global_index');
    }

    public function index(Student $student)
    {
        $student->load('updateRequests.requester', 'updateRequests.approver');
        return view('admin.student_update_requests.index', compact('student'));
    }

    public function store(StoreStudentUpdateRequestRequest $request, Student $student)
    {
        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
            'old_value' => 'nullable|string',
            'new_value' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        StudentUpdateRequest::create([
            'student_id' => $student->id,
            'requested_by' => auth()->id(),
            'field_name' => $validated['field_name'],
            'old_value' => $validated['old_value'] ?? null,
            'new_value' => $validated['new_value'] ?? null,
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
        ]);

        flash()->success('Update request submitted.');
        return redirect()->route('students.update-requests.index', $student);
    }

    public function approve(Request $request, Student $student, StudentUpdateRequest $updateRequest)
    {
        if ($updateRequest->student_id !== $student->id) {
            abort(403);
        }
        $updateRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        flash()->success('Request approved.');
        return redirect()->route('students.update-requests.index', $student);
    }

    public function reject(Request $request, Student $student, StudentUpdateRequest $updateRequest)
    {
        if ($updateRequest->student_id !== $student->id) {
            abort(403);
        }
        $updateRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        flash()->success('Request rejected.');
        return redirect()->route('students.update-requests.index', $student);
    }

    public function destroy(Student $student, StudentUpdateRequest $updateRequest)
    {
        if ($updateRequest->student_id !== $student->id) {
            abort(403);
        }
        $updateRequest->delete();
        flash()->success('Request deleted.');
        return redirect()->route('students.update-requests.index', $student);
    }
}
