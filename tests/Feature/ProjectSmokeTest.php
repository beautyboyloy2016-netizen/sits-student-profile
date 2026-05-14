<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAuthorizedUsers;
use Tests\TestCase;

class ProjectSmokeTest extends TestCase
{
    use CreatesAuthorizedUsers;
    use RefreshDatabase;

    protected function getOrCreateUser(): User
    {
        return User::first() ?? $this->createAuthorizedUser();
    }

    public function test_dashboard_loads_for_authenticated_user()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_students_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/students');
        $response->assertStatus(200);
    }

    public function test_courses_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/courses');
        $response->assertStatus(200);
    }

    public function test_classes_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/classes');
        $response->assertStatus(200);
    }

    public function test_guardians_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/guardians');
        $response->assertStatus(200);
    }

    public function test_rooms_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/rooms');
        $response->assertStatus(200);
    }

    public function test_enrollments_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/enrollments');
        $response->assertStatus(200);
    }

    public function test_fee_types_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/fees/types');
        $response->assertStatus(200);
    }

    public function test_invoices_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/fees/invoices');
        $response->assertStatus(200);
    }

    public function test_payments_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/fees/payments');
        $response->assertStatus(200);
    }

    public function test_staff_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/staff');
        $response->assertStatus(200);
    }

    public function test_staff_create_page_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/staff/create');
        $response->assertStatus(200);
    }

    public function test_academic_years_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/academic-years');
        $response->assertStatus(200);
    }

    public function test_shifts_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/shifts');
        $response->assertStatus(200);
    }

    public function test_print_templates_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/print-templates');
        $response->assertStatus(200);
    }

    public function test_print_templates_create_page_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/print-templates/create');
        $response->assertStatus(200);
    }

    public function test_audit_logs_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/audit-logs');
        $response->assertStatus(200);
    }

    public function test_report_logs_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/report-logs');
        $response->assertStatus(200);
    }

    public function test_export_logs_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/export-logs');
        $response->assertStatus(200);
    }

    public function test_users_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_users_create_page_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/users/create');
        $response->assertStatus(200);
    }

    public function test_roles_index_loads()
    {
        $user = $this->getOrCreateUser();
        $this->actingAs($user);

        $response = $this->get('/admin/roles');
        $response->assertStatus(200);
    }
}
