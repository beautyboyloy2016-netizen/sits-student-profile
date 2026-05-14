<?php

namespace App\Http\Controllers;

use App\Models\PrintLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PrintLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PrintLog::with(['template', 'printer'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('printer_name_col', fn($r) => $r->printer?->name ?? '-')
                ->addColumn('template_name', fn($r) => $r->template?->name ?? '-')
                ->addColumn('printed_at_fmt', fn($r) => $r->printed_at ? \Carbon\Carbon::parse($r->printed_at)->format('d/m/Y H:i') : '-')
                ->rawColumns([])
                ->make(true);
        }
        return view('admin.print_logs.index');
    }
}
