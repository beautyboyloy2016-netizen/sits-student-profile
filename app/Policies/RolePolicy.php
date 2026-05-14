<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-role');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-role');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-role');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-role');
    }
}
