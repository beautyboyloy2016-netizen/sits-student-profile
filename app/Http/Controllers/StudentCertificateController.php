<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentCertificate;
use App\Models\PrintTemplate;
use App\Http\Requests\StudentCertificate\StoreCertificateRequest;
use App\Http\Requests\StudentCertificate\UpdateCertificateRequest;
use Illuminate\Http\Request;

class StudentCertificateController extends Controller
{
    public function globalIndex(Request $request)
    {
        $query = StudentCertificate::with('student', 'template')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('khmer_name', 'like', "%{$search}%")
                  ->orWhere('latin_name', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%");
            });
        }

        $certificates = $query->paginate(50)->withQueryString();
        return view('admin.student_certificates.global_index', compact('certificates'));
    }

    public function index(Student $student)
    {
        $student->load('certificates.template');
        $templates = PrintTemplate::where('template_type', 'certificate')->where('status', 'active')->get();
        return view('admin.student_certificates.index', compact('student', 'templates'));
    }

    public function store(StoreCertificateRequest $request, Student $student)
    {
        StudentCertificate::create([
            'student_id'       => $student->id,
            'certificate_no'   => 'CERT-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
            'certificate_type' => $request->certificate_type,
            'template_id'      => $request->template_id ?? null,
            'title'            => $request->title ?? null,
            'description'      => $request->description ?? null,
            'issue_date'       => $request->issue_date ?? now(),
            'status'           => 'draft',
            'created_by'       => auth()->id(),
        ]);

        flash()->success('Certificate created successfully.');
        return redirect()->route('students.certificates.index', $student);
    }

    public function update(UpdateCertificateRequest $request, Student $student, StudentCertificate $certificate)
    {
        if ($certificate->student_id !== $student->id) {
            abort(403);
        }
        $certificate->update([
            'certificate_type' => $request->certificate_type,
            'template_id'      => $request->template_id ?? $certificate->template_id,
            'title'            => $request->title ?? $certificate->title,
            'description'      => $request->description ?? $certificate->description,
            'issue_date'       => $request->issue_date ?? $certificate->issue_date,
            'status'           => $request->status ?? $certificate->status,
            'updated_by'       => auth()->id(),
        ]);
        flash()->success('Certificate updated successfully.');
        return redirect()->route('students.certificates.index', $student);
    }

    public function approve(Request $request, Student $student, StudentCertificate $certificate)
    {
        if ($certificate->student_id !== $student->id) {
            abort(403);
        }
        $certificate->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        flash()->success('Certificate approved.');
        return redirect()->route('students.certificates.index', $student);
    }

    public function print(Student $student, StudentCertificate $certificate)
    {
        if ($certificate->student_id !== $student->id) {
            abort(403);
        }
        $certificate->load('student');
        $certificate->update([
            'printed_at' => now(),
            'print_count' => ($certificate->print_count ?? 0) + 1,
            'status' => $certificate->status === 'approved' ? 'printed' : $certificate->status,
        ]);
        return view('admin.student_certificates.print', [
            'student' => $certificate->student,
            'certificate' => $certificate,
        ]);
    }

    public function destroy(Student $student, StudentCertificate $certificate)
    {
        if ($certificate->student_id !== $student->id) {
            abort(403);
        }
        $certificate->delete();
        flash()->success('Certificate deleted successfully.');
        return redirect()->route('students.certificates.index', $student);
    }
}
