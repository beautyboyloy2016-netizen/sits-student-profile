<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentDiploma;
use App\Models\PrintTemplate;
use App\Http\Requests\StudentDiploma\StoreDiplomaRequest;
use App\Http\Requests\StudentDiploma\UpdateDiplomaRequest;
use Illuminate\Http\Request;

class StudentDiplomaController extends Controller
{
    public function globalIndex(Request $request)
    {
        $query = StudentDiploma::with('student', 'template')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('khmer_name', 'like', "%{$search}%")
                  ->orWhere('latin_name', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%");
            });
        }

        $diplomas = $query->paginate(50)->withQueryString();
        return view('admin.student_diplomas.global_index', compact('diplomas'));
    }

    public function index(Student $student)
    {
        $student->load('diplomas.template');
        $templates = PrintTemplate::where('template_type', 'diploma')->where('status', 'active')->get();
        return view('admin.student_diplomas.index', compact('student', 'templates'));
    }

    public function store(StoreDiplomaRequest $request, Student $student)
    {
        StudentDiploma::create([
            'student_id'      => $student->id,
            'diploma_no'      => 'DIP-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
            'template_id'     => $request->template_id ?? null,
            'graduation_date' => $request->graduation_date ?? null,
            'issue_date'      => $request->issue_date ?? now(),
            'grade'           => $request->grade ?? null,
            'gpa'             => $request->gpa ?? null,
            'description'     => $request->description ?? null,
            'status'          => 'draft',
            'created_by'      => auth()->id(),
        ]);

        flash()->success('Diploma created successfully.');
        return redirect()->route('students.diplomas.index', $student);
    }

    public function update(UpdateDiplomaRequest $request, Student $student, StudentDiploma $diploma)
    {
        if ($diploma->student_id !== $student->id) {
            abort(403);
        }
        $diploma->update([
            'template_id'     => $request->template_id ?? $diploma->template_id,
            'graduation_date' => $request->graduation_date ?? $diploma->graduation_date,
            'issue_date'      => $request->issue_date ?? $diploma->issue_date,
            'grade'           => $request->grade ?? $diploma->grade,
            'gpa'             => $request->gpa ?? $diploma->gpa,
            'description'     => $request->description ?? $diploma->description,
            'status'          => $request->status ?? $diploma->status,
            'updated_by'      => auth()->id(),
        ]);
        flash()->success('Diploma updated successfully.');
        return redirect()->route('students.diplomas.index', $student);
    }

    public function approve(Request $request, Student $student, StudentDiploma $diploma)
    {
        if ($diploma->student_id !== $student->id) {
            abort(403);
        }
        $diploma->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        flash()->success('Diploma approved.');
        return redirect()->route('students.diplomas.index', $student);
    }

    public function print(Student $student, StudentDiploma $diploma)
    {
        if ($diploma->student_id !== $student->id) {
            abort(403);
        }
        $diploma->load('student');
        $diploma->update([
            'printed_at' => now(),
            'print_count' => ($diploma->print_count ?? 0) + 1,
            'status' => $diploma->status === 'approved' ? 'printed' : $diploma->status,
        ]);
        return view('admin.student_diplomas.print', [
            'student' => $diploma->student,
            'diploma' => $diploma,
        ]);
    }

    public function destroy(Student $student, StudentDiploma $diploma)
    {
        if ($diploma->student_id !== $student->id) {
            abort(403);
        }
        $diploma->delete();
        flash()->success('Diploma deleted successfully.');
        return redirect()->route('students.diplomas.index', $student);
    }
}
