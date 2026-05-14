<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuardianResource;
use App\Http\Resources\StudentDetailResource;
use App\Http\Resources\StudentResource;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Commune;
use App\Models\Course;
use App\Models\District;
use App\Models\Gender;
use App\Models\Guardian;
use App\Models\Level;
use App\Models\Province;
use App\Models\Shift;
use App\Models\Student;
use App\Models\Village;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function students(Request $request)
    {
        $query = Student::with(['gender', 'currentAddress.province', 'currentAddress.district', 'currentAddress.commune']);
        $this->scopeStudentsToCurrentBranch($query);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'like', "%{$search}%")
                    ->orWhere('khmer_name', 'like', "%{$search}%")
                    ->orWhere('latin_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gender_id')) {
            $query->where('gender_id', $request->gender_id);
        }

        $perPage = min(max((int) $request->integer('per_page', 15), 1), 100);
        $students = $query->latest()->paginate($perPage);

        return StudentResource::collection($students);
    }

    public function show(Student $student)
    {
        $this->authorizeStudentBranchAccess($student);

        $student->load([
            'gender',
            'birthPlace.province',
            'birthPlace.district',
            'birthPlace.commune',
            'currentAddress.province',
            'currentAddress.district',
            'currentAddress.commune',
            'guardians.address',
            'enrollments.class.course',
            'enrollments.academicYear',
            'enrollments.shift',
            'files',
        ]);

        return new StudentDetailResource($student);
    }

    public function genders()
    {
        return response()->json(Gender::orderBy('sort_order')->get());
    }

    public function provinces()
    {
        return response()->json(Province::orderBy('name_kh')->get());
    }

    public function districts(Request $request)
    {
        $query = District::query();
        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        return response()->json($query->get());
    }

    public function communes(Request $request)
    {
        $query = Commune::query();
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        return response()->json($query->get());
    }

    public function villages(Request $request)
    {
        $query = Village::query();
        if ($request->filled('commune_id')) {
            $query->where('commune_id', $request->commune_id);
        }

        return response()->json($query->get());
    }

    public function courses()
    {
        return response()->json(Course::where('status', 'active')->get());
    }

    public function levels(Request $request)
    {
        $query = Level::query();
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        return response()->json($query->orderBy('sort_order')->get());
    }

    public function classes(Request $request)
    {
        $query = ClassModel::where('status', 'active')
            ->with(['course', 'level', 'academicYear', 'shift']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }

        return response()->json($query->get());
    }

    public function academicYears()
    {
        return response()->json(AcademicYear::where('status', 'active')->orderByDesc('is_current')->get());
    }

    public function shifts()
    {
        return response()->json(Shift::where('status', 'active')->get());
    }

    public function guardians(Request $request)
    {
        $query = Guardian::with('address');
        if ($request->filled('search')) {
            $query->where('name_kh', 'like', "%{$request->search}%")
                ->orWhere('phone', 'like', "%{$request->search}%");
        }

        return GuardianResource::collection($query->latest()->get());
    }

    public function updateStatus(Request $request, Student $student)
    {
        $this->authorizeStudentBranchAccess($student);

        $validated = $request->validate([
            'status' => 'required|in:active,inactive,graduated,suspended,dropped',
        ]);

        $student->update($validated);

        return response()->json(['message' => 'Status updated successfully.', 'student' => $student]);
    }

    /**
     * Return students enrolled in a specific class (for bulk attendance).
     */
    public function classStudents(ClassModel $class)
    {
        $students = Student::whereHas('enrollments', function ($q) use ($class) {
            $q->where('class_id', $class->id)->where('status', 'studying');
        })
            ->when(current_branch_id(), fn ($q, $branchId) => $q->where('branch_id', $branchId))
            ->select('id', 'student_code', 'khmer_name', 'latin_name')
            ->orderBy('khmer_name')
            ->get();

        return response()->json($students);
    }

    private function scopeStudentsToCurrentBranch($query): void
    {
        if ($branchId = current_branch_id()) {
            $query->where('branch_id', $branchId);
        }
    }

    private function authorizeStudentBranchAccess(Student $student): void
    {
        $branchId = current_branch_id();

        if ($branchId && $student->branch_id && (int) $student->branch_id !== $branchId) {
            abort(403);
        }
    }
}
