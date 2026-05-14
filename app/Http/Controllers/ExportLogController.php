<?php

namespace App\Http\Controllers;

use App\Models\ExportLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExportLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ExportLog::with('exporter')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('exporter_name', fn($r) => $r->exporter?->name ?? '-')
                ->addColumn('exported_at_fmt', fn($r) => $r->exported_at ? \Carbon\Carbon::parse($r->exported_at)->format('d/m/Y H:i') : '-')
                ->rawColumns([])
                ->make(true);
        }
        return view('admin.export_logs.index');
    }
}
