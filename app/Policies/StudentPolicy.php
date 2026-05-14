<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-student');
    }

    public function view(User $user, Student $student): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-student');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-student');
    }

    public function update(User $user, Student $student): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-student');
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-student');
    }
}
