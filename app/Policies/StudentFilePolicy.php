<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentFile;

class StudentFilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-student-file');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('upload-student-file');
    }

    public function update(User $user, StudentFile $file): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-student-file');
    }

    public function delete(User $user, StudentFile $file): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-student-file');
    }
}
