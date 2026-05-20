<?php

namespace App\Http\Controllers;

use App\Models\ReportLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ReportLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ReportLog::with('generator');

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('generator_name', fn($r) => $r->generator?->name ?? '-')
                ->addColumn('generated_at_fmt', fn($r) => $r->generated_at ? \Carbon\Carbon::parse($r->generated_at)->format('d/m/Y H:i') : '-')
                ->rawColumns([])
                ->make(true);
        }
        return view('admin.report_logs.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => ['required', 'string', Rule::in(ReportLog::TYPES)],
            'report_title' => 'nullable|string|max:255',
            'filters' => 'nullable',
            'export_format' => 'required|in:pdf,excel,csv,print,view',
        ]);

        ReportLog::create([
            'branch_id'    => current_branch_id(),
            'report_type'  => $validated['report_type'],
            'report_title' => $validated['report_title'] ?? null,
            'filters'      => $validated['filters'] ?? null,
            'export_format'=> $validated['export_format'],
            'generated_by' => Auth::id(),
            'generated_at' => now(),
        ]);

        flash()->success('Report log created.');
        return redirect()->route('report-logs.index');
    }
}
