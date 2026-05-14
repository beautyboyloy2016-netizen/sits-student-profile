<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\AcademicYear;
use App\Models\Shift;
use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Enrollment::with(['student', 'class.course', 'academicYear', 'shift']);

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('enrollments.branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student_name', fn($r) => $r->student?->khmer_name.' ('.$r->student?->latin_name.')')
                ->addColumn('class_name', fn($r) => ($r->class?->course?->name ?? '-').' - '.($r->class?->class_code ?? '-'))
                ->addColumn('academic_year_name', fn($r) => $r->academicYear?->name ?? '-')
                ->addColumn('shift_name', fn($r) => $r->shift?->name ?? '-')
                ->addColumn('enroll_date_fmt', fn($r) => $r->enroll_date?->format('d/m/Y') ?? '-')
                ->addColumn('status_badge', function ($r) {
                    $map = ['studying'=>'success','completed'=>'info','dropped'=>'danger','transferred'=>'warning'];
                    $color = $map[$r->status] ?? 'secondary';
                    return '<span class="badge badge-'.$color.'">'.ucfirst($r->status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $edit   = '<a href="'.route('enrollments.edit', $row->id).'" class="btn btn-xs btn-warning mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="'.route('enrollments.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return view('admin.enrollments.index');
    }

    public function create()
    {
        $students = Student::where('status', 'active')->orderBy('khmer_name')->get();
        $classes = ClassModel::where('status', 'active')->with('course')->get();
        $academicYears = AcademicYear::where('status', 'active')->orderByDesc('is_current')->get();
        $shifts = Shift::where('status', 'active')->get();

        return view('admin.enrollments.create', compact('students', 'classes', 'academicYears', 'shifts'));
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'enroll_date' => 'nullable|date',
            'study_time_label' => 'nullable|string|max:100',
            'status' => 'required|in:studying,completed,dropped,transferred',
            'note' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['branch_id'] = current_branch_id();

        // Check for duplicate enrollment
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('class_id', $validated['class_id'])
            ->exists();

        if ($exists) {
            flash()->error('Student is already enrolled in this class.');
            return back()->withInput();
        }

            Enrollment::create($validated);
            flash()->success('Enrollment created successfully.');
            return redirect()->route('enrollments.index');
        }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::where('status', 'active')->orderBy('khmer_name')->get();
        $classes = ClassModel::where('status', 'active')->with('course')->get();
        $academicYears = AcademicYear::where('status', 'active')->orderByDesc('is_current')->get();
        $shifts = Shift::where('status', 'active')->get();

        return view('admin.enrollments.edit', compact('enrollment', 'students', 'classes', 'academicYears', 'shifts'));
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'class_id' => 'required|exists:classes,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'enroll_date' => 'nullable|date',
            'study_time_label' => 'nullable|string|max:100',
            'status' => 'required|in:studying,completed,dropped,transferred',
            'note' => 'nullable|string',
        ]);

        $enrollment->update($validated);
        flash()->success('Enrollment updated successfully.');
        return redirect()->route('enrollments.index');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        flash()->success('Enrollment deleted successfully.');
        return redirect()->route('enrollments.index');
    }
}
