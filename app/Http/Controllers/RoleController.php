<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with('permissions')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions_count', fn($r) => $r->permissions->count())
                ->addColumn('action', function($row) {
                    $permIds = $row->permissions->pluck('id')->toArray();
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-role mr-1"'
                        . ' data-id="' . $row->id . '"'
                        . ' data-name="' . e($row->name) . '"'
                        . ' data-display_name="' . e($row->display_name) . '"'
                        . ' data-description="' . e($row->description) . '"'
                        . ' data-permissions=\'' . json_encode($permIds) . '\''
                        . '><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="' . route('roles.destroy', $row->id) . '" method="POST" class="d-inline">' .
                        csrf_field() . '<input type="hidden" name="_method" value="DELETE">' .
                        '<button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button></form>';
                    return $edit . $delete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $permissions = Permission::orderBy('module')->get();
        return view('admin.roles.index', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permission_ids' => 'nullable|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['permission_ids'])) {
            $role->permissions()->attach($validated['permission_ids']);
        }

        flash()->success('Role created successfully.');
        return redirect()->route('roles.index');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permission_ids' => 'nullable|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->permissions()->sync($validated['permission_ids'] ?? []);

        flash()->success('Role updated successfully.');
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        flash()->success('Role deleted successfully.');
        return redirect()->route('roles.index');
    }
}
