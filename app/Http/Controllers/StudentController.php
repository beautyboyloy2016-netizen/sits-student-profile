<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\AcademicYear;
use App\Models\Address;
use App\Models\ClassModel;
use App\Models\Commune;
use App\Models\Course;
use App\Models\District;
use App\Models\Gender;
use App\Models\Guardian;
use App\Models\Province;
use App\Models\Shift;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Student::with('gender')->select('students.*');

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $query->where('students.branch_id', $branchId);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('gender_id')) {
                $query->where('gender_id', $request->gender_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('photo_html', function ($row) {
                    if ($row->photo_path) {
                        return '<img src="'.asset('storage/'.$row->photo_path).'" class="img-circle elevation-2" style="width:35px;height:35px;object-fit:cover;">';
                    }

                    return '<span class="badge badge-secondary"><i class="fas fa-user"></i></span>';
                })
                ->addColumn('gender_name', fn ($row) => $row->gender?->name_kh ?? '-')
                ->addColumn('status_badge', function ($row) {
                    $map = ['active' => 'success', 'inactive' => 'secondary', 'graduated' => 'info', 'suspended' => 'warning', 'dropped' => 'danger'];
                    $color = $map[$row->status] ?? 'secondary';

                    return '<span class="badge badge-'.$color.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $show = '<a href="'.route('students.show', $row->id).'" class="btn btn-xs btn-info mr-1"><i class="fas fa-eye"></i></a>';
                    $edit = '<a href="'.route('students.edit', $row->id).'" class="btn btn-xs btn-warning mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="'.route('students.destroy', $row->id).'" method="POST" class="d-inline">
                                '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                               </form>';

                    return $show.$edit.$delete;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('search.value')) {
                        $search = $request->input('search.value');
                        $query->where(function ($q) use ($search) {
                            $q->where('khmer_name', 'like', "%{$search}%")
                                ->orWhere('latin_name', 'like', "%{$search}%")
                                ->orWhere('student_code', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                    }
                }, true)
                ->rawColumns(['photo_html', 'status_badge', 'action'])
                ->make(true);
        }

        $genders = Gender::orderBy('sort_order')->get();

        return view('admin.students.index', compact('genders'));
    }

    public function create()
    {
        $genders = Gender::orderBy('sort_order')->get();
        $provinces = Province::orderBy('name_kh')->get();
        $courses = Course::where('status', 'active')
            ->whereHas('classes', fn ($q) => $q->where('status', 'active'))
            ->get();
        $academicYears = AcademicYear::where('status', 'active')->orderByDesc('is_current')->get();
        $shifts = Shift::where('status', 'active')->get();

        return view('admin.students.create', compact('genders', 'provinces', 'courses', 'academicYears', 'shifts'));
    }

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Create birth place address
            $birthPlaceId = null;
            if ($request->filled('birth_province_id')) {
                $birthAddress = Address::create([
                    'province_id' => $request->birth_province_id,
                    'district_id' => $request->birth_district_id,
                    'commune_id' => $request->birth_commune_id,
                    'village_id' => $request->birth_village_id,
                    'street' => $request->birth_street,
                    'house_no' => $request->birth_house_no,
                ]);
                $birthPlaceId = $birthAddress->id;
            }

            // Create current address
            $currentAddressId = null;
            if ($request->filled('current_province_id')) {
                $currentAddress = Address::create([
                    'province_id' => $request->current_province_id,
                    'district_id' => $request->current_district_id,
                    'commune_id' => $request->current_commune_id,
                    'village_id' => $request->current_village_id,
                    'street' => $request->current_street,
                    'house_no' => $request->current_house_no,
                ]);
                $currentAddressId = $currentAddress->id;
            }

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                if (! $request->file('photo')->isValid()) {
                    throw new \Exception('Uploaded photo is not valid. Please try again.');
                }
                if (! Storage::disk('public')->exists('students/photos')) {
                    Storage::disk('public')->makeDirectory('students/photos');
                }
                $photoPath = $request->file('photo')->store('students/photos', 'public');
            }

            // Create student
            $student = Student::create([
                'branch_id' => current_branch_id(),
                'student_code' => $validated['student_code'],
                'khmer_name' => $validated['khmer_name'],
                'latin_name' => $validated['latin_name'] ?? null,
                'gender_id' => $validated['gender_id'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'birth_place_id' => $birthPlaceId,
                'current_address_id' => $currentAddressId,
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'] ?? null,
                'photo_path' => $photoPath,
                'status' => $validated['status'],
                'note' => $validated['note'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Create guardian if provided
            if ($request->filled('guardian_name_kh')) {
                $guardian = Guardian::create([
                    'name_kh' => $request->guardian_name_kh,
                    'name_en' => $request->guardian_name_en,
                    'phone' => $request->guardian_phone,
                    'occupation' => $request->guardian_occupation,
                ]);

                $student->guardians()->attach($guardian->id, [
                    'relationship' => $request->guardian_relationship ?? 'parent',
                    'is_primary' => true,
                ]);
            }

            // Create enrollment if class provided
            if ($request->filled('class_id')) {
                $student->enrollments()->create([
                    'branch_id' => current_branch_id(),
                    'class_id' => $request->class_id,
                    'academic_year_id' => $request->academic_year_id,
                    'shift_id' => $request->shift_id,
                    'enroll_date' => $request->enroll_date ?? now(),
                    'status' => 'studying',
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();

            flash()->success('Student created successfully.');

            return redirect()->route('students.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to create student: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function show(Student $student)
    {
        $this->authorizeBranchAccess($student);

        $student->load([
            'gender',
            'birthPlace.province',
            'birthPlace.district',
            'birthPlace.commune',
            'currentAddress.province',
            'currentAddress.district',
            'currentAddress.commune',
            'guardians',
            'enrollments.class.course',
            'enrollments.academicYear',
            'enrollments.shift',
            'files',
            'cards',
            'invoices',
        ]);

        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $this->authorizeBranchAccess($student);

        $student->load([
            'birthPlace',
            'currentAddress',
            'guardians',
            'enrollments.class',
        ]);

        $genders = Gender::orderBy('sort_order')->get();
        $provinces = Province::orderBy('name_kh')->get();
        $courses = Course::where('status', 'active')->get();
        $academicYears = AcademicYear::where('status', 'active')->orderByDesc('is_current')->get();
        $shifts = Shift::where('status', 'active')->get();

        $currentEnrollment = $student->enrollments->first();
        $currentCourseId = $currentEnrollment?->class?->course_id;
        $classesForCourse = $currentCourseId
            ? ClassModel::where('course_id', $currentCourseId)->get()
            : collect();

        $birthDistricts = $student->birthPlace ? District::where('province_id', $student->birthPlace->province_id)->get() : collect();
        $birthCommunes = $student->birthPlace ? Commune::where('district_id', $student->birthPlace->district_id)->get() : collect();
        $currentDistricts = $student->currentAddress ? District::where('province_id', $student->currentAddress->province_id)->get() : collect();
        $currentCommunes = $student->currentAddress ? Commune::where('district_id', $student->currentAddress->district_id)->get() : collect();

        return view('admin.students.edit', compact(
            'student', 'genders', 'provinces', 'courses', 'academicYears', 'shifts',
            'birthDistricts', 'birthCommunes', 'currentDistricts', 'currentCommunes',
            'classesForCourse'
        ));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $this->authorizeBranchAccess($student);

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Handle photo upload
            if ($request->hasFile('photo')) {
                if (! $request->file('photo')->isValid()) {
                    throw new \Exception('Uploaded photo is not valid. Please try again.');
                }
                if (! Storage::disk('public')->exists('students/photos')) {
                    Storage::disk('public')->makeDirectory('students/photos');
                }
                if ($student->photo_path) {
                    Storage::disk('public')->delete($student->photo_path);
                }
                $validated['photo_path'] = $request->file('photo')->store('students/photos', 'public');
            }

            unset($validated['photo']);

            // Update or create birth place address
            $birthPlaceId = $student->birth_place_id;
            if ($request->filled('birth_province_id')) {
                $birthData = [
                    'province_id' => $request->birth_province_id,
                    'district_id' => $request->birth_district_id,
                    'commune_id' => $request->birth_commune_id,
                    'village_id' => $request->birth_village_id,
                    'street' => $request->birth_street,
                    'house_no' => $request->birth_house_no,
                ];
                if ($student->birthPlace) {
                    $student->birthPlace->update($birthData);
                    $birthPlaceId = $student->birthPlace->id;
                } else {
                    $birthAddress = Address::create($birthData);
                    $birthPlaceId = $birthAddress->id;
                }
            }
            $validated['birth_place_id'] = $birthPlaceId;

            // Update or create current address
            $currentAddressId = $student->current_address_id;
            if ($request->filled('current_province_id')) {
                $currentData = [
                    'province_id' => $request->current_province_id,
                    'district_id' => $request->current_district_id,
                    'commune_id' => $request->current_commune_id,
                    'village_id' => $request->current_village_id,
                    'street' => $request->current_street,
                    'house_no' => $request->current_house_no,
                ];
                if ($student->currentAddress) {
                    $student->currentAddress->update($currentData);
                    $currentAddressId = $student->currentAddress->id;
                } else {
                    $currentAddress = Address::create($currentData);
                    $currentAddressId = $currentAddress->id;
                }
            }
            $validated['current_address_id'] = $currentAddressId;

            $validated['updated_by'] = auth()->id();
            $student->update($validated);

            // Update or create guardian
            if ($request->filled('guardian_name_kh')) {
                $primaryGuardian = $student->guardians()->wherePivot('is_primary', true)->first();
                $guardianData = [
                    'name_kh' => $request->guardian_name_kh,
                    'name_en' => $request->guardian_name_en,
                    'phone' => $request->guardian_phone,
                    'occupation' => $request->guardian_occupation,
                ];
                if ($primaryGuardian) {
                    $primaryGuardian->update($guardianData);
                    $student->guardians()->updateExistingPivot($primaryGuardian->id, [
                        'relationship' => $request->guardian_relationship ?? 'parent',
                    ]);
                } else {
                    $guardian = Guardian::create($guardianData);
                    $student->guardians()->attach($guardian->id, [
                        'relationship' => $request->guardian_relationship ?? 'parent',
                        'is_primary' => true,
                    ]);
                }
            }

            // Update or create enrollment
            if ($request->filled('class_id')) {
                $enrollment = $student->enrollments()->first();
                $enrollmentData = [
                    'branch_id' => current_branch_id(),
                    'class_id' => $request->class_id,
                    'academic_year_id' => $request->academic_year_id,
                    'shift_id' => $request->shift_id,
                    'enroll_date' => $request->enroll_date ?? now(),
                ];
                if ($enrollment) {
                    $enrollment->update($enrollmentData);
                } else {
                    $enrollmentData['status'] = 'studying';
                    $enrollmentData['created_by'] = auth()->id();
                    $student->enrollments()->create($enrollmentData);
                }
            }

            DB::commit();

            flash()->success('Student updated successfully.');

            return redirect()->route('students.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to update student: '.$e->getMessage());

            return back()->withInput();
        }
    }

    public function destroy(Student $student)
    {
        $this->authorizeBranchAccess($student);

        try {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $student->delete();
            flash()->success('Student deleted successfully.');
        } catch (\Exception $e) {
            flash()->error('Failed to delete student.');
        }

        return redirect()->route('students.index');
    }

    private function authorizeBranchAccess(Student $student): void
    {
        $branchId = current_branch_id();

        if ($branchId && $student->branch_id && (int) $student->branch_id !== $branchId) {
            abort(403);
        }
    }
}
