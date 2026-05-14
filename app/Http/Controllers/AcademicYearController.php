<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Http\Requests\AcademicYear\StoreAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AcademicYearController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AcademicYear::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_current_badge', fn($r) => $r->is_current ? '<span class="badge badge-primary">'.__('app.is_current').'</span>' : '')
                ->addColumn('status_badge', function ($r) {
                    $map = ['active' => 'success', 'closed' => 'secondary', 'inactive' => 'warning'];
                    $color = $map[$r->status] ?? 'secondary';
                    return '<span class="badge badge-'.$color.'">'.__('app.'.$r->status).'</span>';
                })
                ->addColumn('start_date_fmt', fn($r) => $r->start_date?->format('d/m/Y') ?? '—')
                ->addColumn('end_date_fmt', fn($r) => $r->end_date?->format('d/m/Y') ?? '—')
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-ay mr-1"
                        data-id="'.$row->id.'" data-name="'.e($row->name).'"
                        data-start_date="'.($row->start_date?->format('Y-m-d')??'').'"
                        data-end_date="'.($row->end_date?->format('Y-m-d')??'').'"
                        data-is_current="'.($row->is_current?'1':'0').'"
                        data-status="'.$row->status.'"
                        ><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="'.route('academic-years.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['is_current_badge', 'status_badge', 'action'])                ->make(true);
        }
        $academicYears = AcademicYear::latest()->get();
        return view('admin.academic_years.index', compact('academicYears'));
    }

    public function store(StoreAcademicYearRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'status' => 'required|in:active,inactive,closed',
        ]);

        $validated['is_current'] = $request->boolean('is_current', false);
        if ($validated['is_current']) {
            AcademicYear::where('is_current', true)->update(['is_current' => false]);
        }

        AcademicYear::create($validated);
        flash()->success('Academic year created successfully.');
        return redirect()->route('academic-years.index');
    }

    public function update(UpdateAcademicYearRequest $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:academic_years,name,' . $academicYear->id,
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'status' => 'required|in:active,inactive,closed',
        ]);

        $validated['is_current'] = $request->boolean('is_current', false);
        if ($validated['is_current']) {
            AcademicYear::where('is_current', true)->where('id', '!=', $academicYear->id)->update(['is_current' => false]);
        }

        $academicYear->update($validated);
        flash()->success('Academic year updated successfully.');
        return redirect()->route('academic-years.index');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        flash()->success('Academic year deleted successfully.');
        return redirect()->route('academic-years.index');
    }
}
