<?php

namespace Tests\Concerns;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\BranchSeeder;
use Database\Seeders\RolesPermissionsSeeder;

trait CreatesAuthorizedUsers
{
    protected function createAuthorizedUser(): User
    {
        $this->seed(BranchSeeder::class);
        $this->seed(RolesPermissionsSeeder::class);

        $branch = Branch::where('code', 'MAIN')->first() ?? Branch::first();

        $user = User::factory()->create([
            'name' => 'Test Super Admin',
            'email' => 'admin@example.com',
            'status' => 'active',
            'branch_id' => $branch?->id,
        ]);

        $role = Role::where('name', 'super_admin')->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }

        if ($branch) {
            $user->branches()->syncWithoutDetaching([$branch->id]);
            session(['current_branch_id' => $branch->id]);
        }

        return $user;
    }

    protected function actingAsAuthorizedUser(): self
    {
        return $this->actingAs($this->createAuthorizedUser());
    }
}
