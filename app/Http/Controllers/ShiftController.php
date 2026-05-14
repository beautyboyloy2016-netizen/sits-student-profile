<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Http\Requests\Shift\StoreShiftRequest;
use App\Http\Requests\Shift\UpdateShiftRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shift::latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_badge', fn($r) => '<span class="badge badge-'.($r->status==='active'?'success':'secondary').'">'.__('app.'.$r->status).'</span>')
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-shift mr-1"
                        data-id="'.$row->id.'" data-name="'.e($row->name).'"
                        data-start_time="'.($row->start_time??'').'"
                        data-end_time="'.($row->end_time??'').'"
                        data-status="'.$row->status.'"
                        ><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="'.route('shifts.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        $shifts = Shift::latest()->get();
        return view('admin.shifts.index', compact('shifts'));
    }

    public function store(StoreShiftRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after_or_equal:start_time',
            'status' => 'required|in:active,inactive',
        ]);

        Shift::create($validated);
        flash()->success('Shift created successfully.');
        return redirect()->route('shifts.index');
    }

    public function update(UpdateShiftRequest $request, Shift $shift)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after_or_equal:start_time',
            'status' => 'required|in:active,inactive',
        ]);

        $shift->update($validated);
        flash()->success('Shift updated successfully.');
        return redirect()->route('shifts.index');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        flash()->success('Shift deleted successfully.');
        return redirect()->route('shifts.index');
    }
}
