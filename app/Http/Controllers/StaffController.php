<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Gender;
use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Staff::with('gender');

            // Branch isolation
            $branchId = current_branch_id();
            if ($branchId) {
                $data->where('staff.branch_id', $branchId);
            }

            $data->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gender_name', fn($r) => $r->gender?->name_kh ?? '-')
                ->addColumn('status_badge', fn($r) => '<span class="badge badge-'.($r->status==='active'?'success':'secondary').'">'.ucfirst($r->status).'</span>')
                ->addColumn('action', function ($row) {
                    $show   = '<a href="'.route('staff.show', $row->id).'" class="btn btn-xs btn-info mr-1"><i class="fas fa-eye"></i></a>';
                    $edit   = '<a href="'.route('staff.edit', $row->id).'" class="btn btn-xs btn-warning mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="'.route('staff.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $show . $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        $staff = Staff::with('gender', 'user')->latest()->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $genders = Gender::orderBy('sort_order')->get();
        return view('admin.staff.create', compact('genders'));
    }

    public function store(StoreStaffRequest $request)
    {
        $validated = $request->validate([
            'staff_code' => 'required|string|unique:staff',
            'name_kh' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'gender_id' => 'nullable|exists:genders,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:staff',
            'position' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['branch_id'] = current_branch_id();

        Staff::create($validated);
        flash()->success('Staff created successfully.');
        return redirect()->route('staff.index');
    }

    public function show(Staff $staff)
    {
        $staff->load('gender', 'classes', 'user');
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $genders = Gender::orderBy('sort_order')->get();
        return view('admin.staff.edit', compact('staff', 'genders'));
    }

    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $validated = $request->validate([
            'staff_code' => 'required|string|unique:staff,staff_code,' . $staff->id,
            'name_kh' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'gender_id' => 'nullable|exists:genders,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:staff,email,' . $staff->id,
            'position' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $staff->update($validated);
        flash()->success('Staff updated successfully.');
        return redirect()->route('staff.index');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        flash()->success('Staff deleted successfully.');
        return redirect()->route('staff.index');
    }
}
