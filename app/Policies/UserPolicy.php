<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-user');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-user');
    }

    public function update(User $authUser, User $target): bool
    {
        return $authUser->hasRole('admin') || $authUser->hasPermission('edit-user');
    }

    public function delete(User $authUser, User $target): bool
    {
        if ($authUser->id === $target->id) {
            return false;
        }
        return $authUser->hasRole('admin') || $authUser->hasPermission('delete-user');
    }
}
