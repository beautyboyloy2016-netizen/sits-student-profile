<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enrollment;

class EnrollmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-enrollment');
    }

    public function view(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-enrollment');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-enrollment');
    }

    public function update(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-enrollment');
    }

    public function delete(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-enrollment');
    }
}
