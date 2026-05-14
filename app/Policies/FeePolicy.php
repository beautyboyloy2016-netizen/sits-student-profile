<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentInvoice;

class FeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-fee');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-fee');
    }

    public function update(User $user, StudentInvoice $invoice): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-fee');
    }

    public function delete(User $user, StudentInvoice $invoice): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-fee');
    }
}
