<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentCard;

class StudentCardPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-student-card');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-student-card');
    }

    public function update(User $user, StudentCard $card): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-student-card');
    }

    public function delete(User $user, StudentCard $card): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-student-card');
    }
}
