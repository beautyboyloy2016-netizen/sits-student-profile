<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\ClassModel;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $branchId = current_branch_id();
            $type     = $request->get('attendable_type', 'student');
            $date     = $request->get('date', today()->toDateString());
            $classId  = $request->get('class_id');

            $query = Attendance::with(['recorder'])
                ->where('attendable_type', $type)
                ->whereDate('date', $date);

            if ($branchId) {
                $query->where('branch_id', $branchId);
            }
            if ($classId) {
                $query->where('class_id', $classId);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('attendable_name', function ($row) {
                    if ($row->attendable_type === 'student') {
                        $s = Student::find($row->attendable_id);
                        return $s ? $s->khmer_name . ($s->latin_name ? " ({$s->latin_name})" : '') : '-';
                    }
                    $st = Staff::find($row->attendable_id);
                    return $st ? $st->name_kh . ($st->name_en ? " ({$st->name_en})" : '') : '-';
                })
                ->addColumn('status_badge', function ($row) {
                    $colors = [
                        'present' => 'success',
                        'absent'  => 'danger',
                        'late'    => 'warning',
                        'excused' => 'info',
                    ];
                    $color = $colors[$row->status] ?? 'secondary';
                    return '<span class="badge badge-' . $color . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $edit   = '<button class="btn btn-xs btn-warning btn-edit-attendance mr-1" data-id="' . $row->id . '"><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="' . route('attendances.destroy', $row->id) . '" method="POST" class="d-inline">'
                        . csrf_field() . '<input type="hidden" name="_method" value="DELETE">'
                        . '<button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>'
                        . '</form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $branchId   = current_branch_id();
        $attendType = $request->get('attendable_type', 'student');
        $classes    = ClassModel::when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->where('status', 'active')
            ->get();

        return view('admin.attendances.index', compact('classes', 'attendType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id'       => 'nullable|exists:branches,id',
            'attendable_type' => 'required|in:student,staff',
            'attendable_id'   => 'required|integer',
            'class_id'        => 'nullable|exists:classes,id',
            'date'            => 'required|date',
            'status'          => 'required|in:present,absent,late,excused',
            'check_in_time'   => 'nullable|date_format:H:i',
            'check_out_time'  => 'nullable|date_format:H:i',
            'note'            => 'nullable|string|max:500',
        ]);

        $validated['branch_id']   = $validated['branch_id'] ?? current_branch_id();
        $validated['recorded_by'] = auth()->id();

        Attendance::updateOrCreate(
            [
                'attendable_type' => $validated['attendable_type'],
                'attendable_id'   => $validated['attendable_id'],
                'date'            => $validated['date'],
            ],
            $validated
        );

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        flash()->success(__('app.saved_successfully'));
        return back();
    }

    /**
     * Bulk store attendance for an entire class.
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'class_id'      => 'required|exists:classes,id',
            'date'          => 'required|date',
            'attendances'   => 'required|array',
            'attendances.*.student_id' => 'required|exists:students,id',
            'attendances.*.status'     => 'required|in:present,absent,late,excused',
        ]);

        $branchId = current_branch_id();

        foreach ($request->input('attendances') as $row) {
            Attendance::updateOrCreate(
                [
                    'attendable_type' => 'student',
                    'attendable_id'   => $row['student_id'],
                    'date'            => $request->date,
                ],
                [
                    'branch_id'       => $branchId,
                    'class_id'        => $request->class_id,
                    'status'          => $row['status'],
                    'check_in_time'   => $row['check_in_time'] ?? null,
                    'check_out_time'  => $row['check_out_time'] ?? null,
                    'note'            => $row['note'] ?? null,
                    'recorded_by'     => auth()->id(),
                ]
            );
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        flash()->success(__('app.saved_successfully'));
        return back();
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'status'         => 'required|in:present,absent,late,excused',
            'check_in_time'  => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'note'           => 'nullable|string|max:500',
        ]);

        $attendance->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        flash()->success(__('app.saved_successfully'));
        return back();
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        flash()->success(__('app.deleted_successfully'));
        return back();
    }
}
