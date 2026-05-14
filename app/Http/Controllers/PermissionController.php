<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::orderBy('module')->orderBy('name');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-permission mr-1"'
                        . ' data-id="' . $row->id . '"'
                        . ' data-name="' . e($row->name) . '"'
                        . ' data-module="' . e($row->module) . '"'
                        . ' data-display_name="' . e($row->display_name) . '"'
                        . ' data-description="' . e($row->description) . '"'
                        . '><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="' . route('permissions.destroy', $row->id) . '" method="POST" class="d-inline">' .
                        csrf_field() . '<input type="hidden" name="_method" value="DELETE">' .
                        '<button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button></form>';
                    return $edit . $delete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    public function store(StorePermissionRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'module' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Permission::create($validated);
        flash()->success('Permission created successfully.');
        return redirect()->route('permissions.index');
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'module' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $permission->update($validated);
        flash()->success('Permission updated successfully.');
        return redirect()->route('permissions.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        flash()->success('Permission deleted successfully.');
        return redirect()->route('permissions.index');
    }
}
