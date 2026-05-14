<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Branch::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_main_badge', function ($row) {
                    return $row->is_main
                        ? '<span class="badge badge-success">Main</span>'
                        : '<span class="badge badge-secondary">Branch</span>';
                })
                ->addColumn('status_badge', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $settings = '<a href="'.route('branch-settings.edit', $row->id).'" class="btn btn-xs btn-secondary mr-1" title="Settings"><i class="fas fa-cog"></i></a>';
                    $edit = '<a href="'.route('branches.edit', $row->id).'" class="btn btn-xs btn-info mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="'.route('branches.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';

                    return $settings.$edit.$delete;
                })
                ->rawColumns(['is_main_badge', 'status_badge', 'action'])
                ->make(true);
        }

        return view('admin.branches.index');
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(StoreBranchRequest $request)
    {
        $validated = $request->validated();

        if (! empty($validated['is_main'])) {
            Branch::where('is_main', true)->update(['is_main' => false]);
        }

        Branch::create($validated);
        flash()->success('Branch created successfully.');

        return redirect()->route('branches.index');
    }

    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $validated = $request->validated();

        if (! empty($validated['is_main']) && ! $branch->is_main) {
            Branch::where('is_main', true)->update(['is_main' => false]);
        }

        $branch->update($validated);
        flash()->success('Branch updated successfully.');

        return redirect()->route('branches.index');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        flash()->success('Branch deleted successfully.');

        return redirect()->route('branches.index');
    }

    public function switchBranch(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|integer|exists:branches,id',
        ]);

        $user = auth()->user();
        $branchId = $request->integer('branch_id');

        if (! $user->canAccessBranch($branchId)) {
            return back()->withErrors(['branch_id' => 'You do not have access to that branch.']);
        }

        session(['current_branch_id' => $branchId]);
        flash()->success('Switched branch successfully.');

        return back();
    }
}
