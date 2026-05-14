<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentFile\StoreStudentFileRequest;
use App\Http\Requests\StudentFile\UpdateStudentFileRequest;
use App\Models\FileAccessLog;
use App\Models\FileProtectionRule;
use App\Models\Student;
use App\Models\StudentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StudentFileController extends Controller
{
    public function globalIndex(Request $request)
    {
        if ($request->ajax()) {
            $files = StudentFile::with('student', 'uploader')->latest();
            if ($branchId = current_branch_id()) {
                $files->whereHas('student', fn ($q) => $q->where('branch_id', $branchId));
            }

            return DataTables::of($files)
                ->addIndexColumn()
                ->addColumn('student_name', fn ($f) => $f->student
                    ? '<a href="'.route('students.show', $f->student).'">'.e($f->student->khmer_name).'</a>'
                    : '<span class="text-muted">N/A</span>')
                ->addColumn('file_type_label', fn ($f) => ucwords(str_replace('_', ' ', $f->file_type)))
                ->addColumn('size_label', fn ($f) => $f->size ? number_format($f->size / 1024, 1).' KB' : '—')
                ->addColumn('is_primary_label', fn ($f) => $f->is_primary
                    ? '<span class="badge badge-primary">'.__('app.yes').'</span>'
                    : '—')
                ->addColumn('uploaded_by_name', fn ($f) => $f->uploader?->name ?? '—')
                ->addColumn('uploaded_at_fmt', fn ($f) => $f->created_at?->format('d/m/Y H:i') ?? '—')
                ->addColumn('actions', function ($f) {
                    if (! $f->student) {
                        return '';
                    }

                    return '<a href="'.route('students.files.index', $f->student).'" class="btn btn-xs btn-info"><i class="fas fa-eye"></i></a>';
                })
                ->rawColumns(['student_name', 'is_primary_label', 'actions'])
                ->make(true);
        }

        return view('admin.student_files.global_index');
    }

    public function index(Student $student)
    {
        $this->authorizeBranchAccess($student);

        $student->load('files.uploader');

        return view('admin.student_files.index', compact('student'));
    }

    public function store(StoreStudentFileRequest $request, Student $student)
    {
        $this->authorizeBranchAccess($student);

        $file = $request->file('file');
        $path = $file->store('student_files/'.$student->id, 'local');

        StudentFile::create([
            'student_id' => $student->id,
            'file_type' => $request->file_type,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'is_primary' => $request->boolean('is_primary', false),
            'uploaded_by' => auth()->id(),
        ]);

        flash()->success('File uploaded successfully.');

        return redirect()->route('students.files.index', $student);
    }

    public function download(Request $request, Student $student, StudentFile $file)
    {
        $this->authorizeFileBelongsToStudent($student, $file);
        $this->authorizeBranchAccess($student);
        $this->authorizeFileDownload($file);

        FileAccessLog::create([
            'user_id' => auth()->id(),
            'student_file_id' => $file->id,
            'action' => 'download',
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $disk = Storage::disk('local')->exists($file->file_path) ? 'local' : 'public';

        if (! Storage::disk($disk)->exists($file->file_path)) {
            abort(404);
        }

        return Storage::disk($disk)->download($file->file_path, $file->original_name, [
            'Content-Type' => $file->mime_type ?: 'application/octet-stream',
        ]);
    }

    public function update(UpdateStudentFileRequest $request, Student $student, StudentFile $file)
    {
        $this->authorizeFileBelongsToStudent($student, $file);
        $this->authorizeBranchAccess($student);

        $updateData = ['file_type' => $request->file_type, 'is_primary' => $request->boolean('is_primary', false)];

        if ($request->hasFile('file')) {
            $this->deleteStoredFile($file->file_path);
            $newFile = $request->file('file');
            $updateData['file_path'] = $newFile->store('student_files/'.$student->id, 'local');
            $updateData['original_name'] = $newFile->getClientOriginalName();
            $updateData['mime_type'] = $newFile->getMimeType();
            $updateData['size'] = $newFile->getSize();
        }

        $file->update($updateData);
        flash()->success('File updated successfully.');

        return redirect()->route('students.files.index', $student);
    }

    public function destroy(Student $student, StudentFile $file)
    {
        $this->authorizeFileBelongsToStudent($student, $file);
        $this->authorizeBranchAccess($student);

        $this->deleteStoredFile($file->file_path);
        $file->delete();
        flash()->success('File deleted successfully.');

        return redirect()->route('students.files.index', $student);
    }

    private function authorizeFileBelongsToStudent(Student $student, StudentFile $file): void
    {
        if ((int) $file->student_id !== (int) $student->id) {
            abort(403);
        }
    }

    private function authorizeBranchAccess(Student $student): void
    {
        $branchId = current_branch_id();

        if ($branchId && $student->branch_id && (int) $student->branch_id !== $branchId) {
            abort(403);
        }
    }

    private function authorizeFileDownload(StudentFile $file): void
    {
        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        $roleIds = $user->roles()->pluck('roles.id');
        $rules = FileProtectionRule::where(function ($query) {
            $query->whereNull('module')->orWhere('module', 'student_files');
        })
            ->where(function ($query) use ($roleIds) {
                $query->whereNull('role_id')->orWhereIn('role_id', $roleIds);
            })
            ->get();

        if ($rules->isEmpty()) {
            return;
        }

        $roleRules = $rules->whereNotNull('role_id');
        $effectiveRules = $roleRules->isNotEmpty() ? $roleRules : $rules;

        if (! $effectiveRules->contains(fn ($rule) => (bool) $rule->allow_download)) {
            FileAccessLog::create([
                'user_id' => $user->id,
                'student_file_id' => $file->id,
                'action' => 'download_denied',
                'ip_address' => request()->ip(),
                'user_agent' => (string) request()->userAgent(),
            ]);

            abort(403);
        }
    }

    private function deleteStoredFile(string $path): void
    {
        Storage::disk('local')->delete($path);
        Storage::disk('public')->delete($path);
    }
}
