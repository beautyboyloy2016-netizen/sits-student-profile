<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AuditLog::with('user');

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', fn($r) => $r->user?->name ?? '-')
                ->addColumn('created_at_fmt', fn($r) => $r->created_at?->format('d/m/Y H:i') ?? '-')
                ->rawColumns([])
                ->make(true);
        }
        return view('admin.audit_logs.index');
    }
}
