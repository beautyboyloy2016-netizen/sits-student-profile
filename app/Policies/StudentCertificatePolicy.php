<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentCertificate;

class StudentCertificatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-certificate');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-certificate');
    }

    public function update(User $user, StudentCertificate $certificate): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-certificate');
    }

    public function approve(User $user, StudentCertificate $certificate): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('approve-certificate');
    }

    public function delete(User $user, StudentCertificate $certificate): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-certificate');
    }
}
