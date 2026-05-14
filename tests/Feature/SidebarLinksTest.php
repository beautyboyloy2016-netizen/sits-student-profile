<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\CreatesAuthorizedUsers;
use Tests\TestCase;

class SidebarLinksTest extends TestCase
{
    use CreatesAuthorizedUsers;
    use RefreshDatabase;

    protected function user(): User
    {
        return User::first() ?? $this->createAuthorizedUser();
    }

    #[DataProvider('sidebarRoutes')]
    public function test_sidebar_route_loads(string $routeName)
    {
        $this->actingAs($this->user());
        $url = route($routeName);
        $response = $this->get($url);
        $this->assertSame(
            200,
            $response->status(),
            "Route [{$routeName}] returned {$response->status()} instead of 200"
        );
    }

    public static function sidebarRoutes(): array
    {
        return [
            'dashboard' => ['dashboard'],
            'students.index' => ['students.index'],
            'students.create' => ['students.create'],
            'guardians.index' => ['guardians.index'],
            'guardians.create' => ['guardians.create'],
            'staff.index' => ['staff.index'],
            'staff.create' => ['staff.create'],
            'courses.index' => ['courses.index'],

            'classes.index' => ['classes.index'],
            'classes.create' => ['classes.create'],
            'enrollments.index' => ['enrollments.index'],
            'enrollments.create' => ['enrollments.create'],
            'academic-years.index' => ['academic-years.index'],
            'shifts.index' => ['shifts.index'],
            'rooms.index' => ['rooms.index'],
            'fees.types' => ['fees.types'],
            'fees.invoices' => ['fees.invoices'],
            'fees.invoices.create' => ['fees.invoices.create'],
            'fees.payments' => ['fees.payments'],
            'fees.payments.create' => ['fees.payments.create'],
            'print-templates.index' => ['print-templates.index'],
            'print-templates.create' => ['print-templates.create'],
            'users.index' => ['users.index'],
            'users.create' => ['users.create'],
            'roles.index' => ['roles.index'],
            'audit-logs.index' => ['audit-logs.index'],
            'report-logs.index' => ['report-logs.index'],
            'export-logs.index' => ['export-logs.index'],
            'print-logs.index' => ['print-logs.index'],
            'file-access-logs.index' => ['file-access-logs.index'],
            'permissions.index' => ['permissions.index'],
            'genders.index' => ['genders.index'],
            'locations.index' => ['locations.index'],
            'file-protection-rules.index' => ['file-protection-rules.index'],
            'profile.edit' => ['profile.edit'],
        ];
    }
}
