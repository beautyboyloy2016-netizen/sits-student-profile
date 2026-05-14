<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Level;
use App\Models\AcademicYear;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\Room;
use App\Http\Requests\ClassRoom\StoreClassRequest;
use App\Http\Requests\ClassRoom\UpdateClassRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ClassModel::with(['course', 'level', 'academicYear', 'shift', 'teacher', 'room'])
                ->withCount('enrollments');

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('classes.branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('course_name', fn($r) => $r->course?->name ?? '-')
                ->addColumn('level_name', fn($r) => $r->level?->name ?? '-')
                ->addColumn('academic_year_name', fn($r) => $r->academicYear?->name ?? '-')
                ->addColumn('shift_name', fn($r) => $r->shift?->name ?? '-')
                ->addColumn('teacher_name', fn($r) => $r->teacher?->name_en ?? '-')
                ->addColumn('status_badge', fn($r) => '<span class="badge badge-'.($r->status==='active'?'success':($r->status==='completed'?'info':'secondary')).'">'.ucfirst($r->status).'</span>')
                ->addColumn('action', function ($row) {
                    $edit   = '<a href="'.route('classes.edit', $row->id).'" class="btn btn-xs btn-warning mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="'.route('classes.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        $classes = ClassModel::with(['course', 'level', 'academicYear', 'shift', 'teacher', 'room'])
            ->latest()
            ->get();

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $courses = Course::where('status', 'active')->get();
        $levels = Level::orderBy('sort_order')->get();
        $academicYears = AcademicYear::where('status', 'active')->orderByDesc('is_current')->get();
        $shifts = Shift::where('status', 'active')->get();
        $teachers = Staff::where('status', 'active')->get();
        $rooms = Room::where('status', 'available')->orWhere('status', 'full')->get();

        return view('admin.classes.create', compact('courses', 'levels', 'academicYears', 'shifts', 'teachers', 'rooms'));
    }

    public function store(StoreClassRequest $request)
    {
        $validated = $request->validate([
            'class_code' => 'required|string|unique:classes',
            'course_id' => 'required|exists:courses,id',
            'level_id' => 'nullable|exists:levels,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'teacher_id' => 'nullable|exists:staff,id',
            'room_id' => 'nullable|exists:rooms,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $validated['branch_id'] = current_branch_id();
        ClassModel::create($validated);
        flash()->success('Class created successfully.');
        return redirect()->route('classes.index');
    }

    public function edit(ClassModel $class)
    {
        $courses = Course::where('status', 'active')->get();
        $levels = Level::orderBy('sort_order')->get();
        $academicYears = AcademicYear::where('status', 'active')->orderByDesc('is_current')->get();
        $shifts = Shift::where('status', 'active')->get();
        $teachers = Staff::where('status', 'active')->get();
        $rooms = Room::whereIn('status', ['available', 'full'])->get();

        return view('admin.classes.edit', compact('class', 'courses', 'levels', 'academicYears', 'shifts', 'teachers', 'rooms'));
    }

    public function update(UpdateClassRequest $request, ClassModel $class)
    {
        $validated = $request->validate([
            'class_code' => 'required|string|unique:classes,class_code,' . $class->id,
            'course_id' => 'required|exists:courses,id',
            'level_id' => 'nullable|exists:levels,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'teacher_id' => 'nullable|exists:staff,id',
            'room_id' => 'nullable|exists:rooms,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $class->update($validated);
        flash()->success('Class updated successfully.');
        return redirect()->route('classes.index');
    }

    public function destroy(ClassModel $class)
    {
        try {
            $class->delete();
            flash()->success('Class deleted successfully.');
        } catch (\Exception $e) {
            flash()->error('Cannot delete class with existing enrollments.');
        }

        return redirect()->route('classes.index');
    }
}
