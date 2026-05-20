<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('roles')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles_list', fn($r) => $r->roles->pluck('display_name')->join(', ') ?: '-')
                ->addColumn('status_badge', fn($r) => match($r->status) {
                    'active' => '<span class="badge badge-success">' . __('app.active') . '</span>',
                    'blocked' => '<span class="badge badge-danger">' . __('app.blocked') . '</span>',
                    default => '<span class="badge badge-secondary">' . __('app.'.$r->status) . '</span>',
                })
                ->addColumn('action', function($row) {
                    $edit = '<a href="' . route('users.edit', $row->id) . '" class="btn btn-xs btn-warning mr-1"><i class="fas fa-edit"></i></a>';
                    $delete = '<form action="' . route('users.destroy', $row->id) . '" method="POST" class="d-inline">' .
                        csrf_field() . '<input type="hidden" name="_method" value="DELETE">' .
                        '<button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button></form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function create()
    {
        $roles = Role::all();
        $branches = Branch::orderBy('sort_order')->get();
        return view('admin.users.create', compact('roles', 'branches'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users',
            'phone' => 'nullable|string|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:active,inactive,blocked',
            'branch_id' => 'nullable|exists:branches,id',
            'photo' => 'nullable|image|max:2048',
            'role_ids' => 'nullable|array',
            'role_ids.*' => 'exists:roles,id',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users/photos', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'photo' => $photoPath,
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
            'branch_id' => $validated['branch_id'] ?? null,
        ]);

        if (!empty($validated['role_ids'])) {
            $user->roles()->attach($validated['role_ids']);
        }

        if (!empty($validated['branch_ids'])) {
            $user->branches()->attach($validated['branch_ids']);
        }

        flash()->success('User created successfully.');
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::orderBy('sort_order')->get();
        $user->load('roles', 'branches');
        return view('admin.users.edit', compact('user', 'roles', 'branches'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive,blocked',
            'branch_id' => 'nullable|exists:branches,id',
            'photo' => 'nullable|image|max:2048',
            'role_ids' => 'nullable|array',
            'role_ids.*' => 'exists:roles,id',
            'branch_ids' => 'nullable|array',
            'branch_ids.*' => 'exists:branches,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
            'branch_id' => $validated['branch_id'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users/photos', 'public');
        }

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $user->roles()->sync($validated['role_ids'] ?? []);
        $user->branches()->sync($validated['branch_ids'] ?? []);

        flash()->success('User updated successfully.');
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            flash()->error('Cannot delete yourself.');
            return redirect()->route('users.index');
        }
        $user->delete();
        flash()->success('User deleted successfully.');
        return redirect()->route('users.index');
    }
}
