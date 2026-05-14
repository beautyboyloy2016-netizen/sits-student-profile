<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PrintTemplate;

class PrintTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('view-print-template');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('create-print-template');
    }

    public function update(User $user, PrintTemplate $template): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('edit-print-template');
    }

    public function delete(User $user, PrintTemplate $template): bool
    {
        return $user->hasRole('admin') || $user->hasPermission('delete-print-template');
    }
}
