<?php

namespace App\Http\Controllers;

use App\Models\FileAccessLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FileAccessLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FileAccessLog::with(['user', 'studentFile.student'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', fn($r) => $r->user?->name ?? '-')
                ->addColumn('file_name', fn($r) => $r->studentFile?->original_name ?? '-')
                ->addColumn('student_name', fn($r) => $r->studentFile?->student?->khmer_name ?? '-')
                ->addColumn('created_at_fmt', fn($r) => $r->created_at?->format('d/m/Y H:i') ?? '-')
                ->rawColumns([])
                ->make(true);
        }
        return view('admin.file_access_logs.index');
    }
}
