<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentDiploma;

class StudentDiplomaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-diploma');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-diploma');
    }

    public function update(User $user, StudentDiploma $diploma): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-diploma');
    }

    public function approve(User $user, StudentDiploma $diploma): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('approve-diploma');
    }

    public function delete(User $user, StudentDiploma $diploma): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-diploma');
    }
}
