<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Building;
use App\Models\ClassModel;
use App\Models\Commune;
use App\Models\Course;
use App\Models\District;
use App\Models\FeeType;
use App\Models\Gender;
use App\Models\Guardian;
use App\Models\Level;
use App\Models\Province;
use App\Models\Shift;
use App\Models\User;
use Database\Seeders\BasicDataSeeder;
use Database\Seeders\GendersSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesAuthorizedUsers;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use CreatesAuthorizedUsers;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(BasicDataSeeder::class);
        $this->seed(GendersSeeder::class);
        $this->createAuthorizedUser();
    }

    protected function actingAsUser()
    {
        $user = User::first();

        return $this->actingAs($user);
    }

    public function test_student_create_page_loads()
    {
        $response = $this->actingAsUser()->get('/admin/students/create');
        $response->assertStatus(200);
    }

    public function test_student_can_be_created()
    {
        $gender = Gender::first();
        $response = $this->actingAsUser()->post('/admin/students', [
            'student_code' => 'STU-'.uniqid(),
            'khmer_name' => 'ចន ដូ',
            'latin_name' => 'John Doe',
            'gender_id' => $gender?->id,
            'date_of_birth' => '2000-01-01',
            'phone' => '012345678',
            'email' => 'john'.uniqid().'@test.com',
            'status' => 'active',
            'note' => 'Test student',
        ]);
        $response->assertRedirect('/admin/students');
    }

    public function test_student_api_returns_data()
    {
        $response = $this->actingAsUser()->getJson('/api/students');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_api_genders()
    {
        $response = $this->actingAsUser()->getJson('/api/genders');
        $response->assertStatus(200);
    }

    public function test_api_provinces()
    {
        $response = $this->actingAsUser()->getJson('/api/provinces');
        $response->assertStatus(200);
    }

    public function test_api_villages()
    {
        $response = $this->actingAsUser()->getJson('/api/villages');
        $response->assertStatus(200);
    }

    public function test_village_can_be_created()
    {
        $province = Province::first();
        $district = District::create([
            'province_id' => $province->id,
            'name_kh' => 'Test District',
        ]);
        $commune = Commune::create([
            'district_id' => $district->id,
            'province_id' => $province->id,
            'name_kh' => 'Test Commune',
        ]);
        $response = $this->actingAsUser()->post('/admin/locations/villages', [
            'commune_id' => $commune->id,
            'name_kh' => 'Test Village '.uniqid(),
            'type' => 'ភូមិ',
        ]);
        $response->assertRedirect('/admin/locations');
        $this->assertDatabaseHas('villages', ['commune_id' => $commune->id]);
    }

    public function test_api_courses()
    {
        $response = $this->actingAsUser()->getJson('/api/courses');
        $response->assertStatus(200);
    }

    public function test_api_levels()
    {
        $course = Course::first();
        $response = $this->actingAsUser()->getJson('/api/levels?course_id='.$course?->id);
        $response->assertStatus(200);
    }

    public function test_course_can_be_created()
    {
        $response = $this->actingAsUser()->post('/admin/courses', [
            'name' => 'Test Course '.uniqid(),
            'description' => 'Test description',
            'status' => 'active',
        ]);
        $response->assertRedirect('/admin/courses');
    }

    public function test_level_can_be_added_via_api()
    {
        $course = Course::first();
        $response = $this->actingAsUser()->postJson('/admin/courses/levels', [
            'course_id' => $course->id,
            'name' => 'Test Level '.uniqid(),
            'sort_order' => 99,
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Level created successfully.');
    }

    public function test_class_can_be_created()
    {
        $course = Course::first();
        $level = Level::where('course_id', $course->id)->first();
        $year = AcademicYear::first();
        $shift = Shift::first();

        $response = $this->actingAsUser()->post('/admin/classes', [
            'class_code' => 'CLS-'.uniqid(),
            'course_id' => $course->id,
            'level_id' => $level?->id,
            'academic_year_id' => $year?->id,
            'shift_id' => $shift?->id,
            'status' => 'active',
        ]);
        $response->assertRedirect('/admin/classes');
    }

    public function test_guardian_can_be_created()
    {
        $countBefore = Guardian::count();
        $response = $this->actingAsUser()
            ->from('/admin/guardians/create')
            ->post('/admin/guardians', [
                'name_kh' => 'ចន ដូអាណាព្យាបាល',
                'name_en' => 'John Guardian',
                'phone' => '012345679',
                'occupation' => 'Teacher',
                'relationship' => 'Father',
            ]);
        $countAfter = Guardian::count();
        $this->assertGreaterThan($countBefore, $countAfter, 'Guardian should be created');
        $response->assertRedirect();
    }

    public function test_building_can_be_created()
    {
        $response = $this->actingAsUser()->postJson('/admin/rooms/buildings', [
            'name' => 'Building '.uniqid(),
            'status' => 'active',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Building created successfully.');
    }

    public function test_room_can_be_created()
    {
        $building = Building::first();
        if (! $building) {
            $building = Building::create(['name' => 'Test Building', 'status' => 'active']);
        }
        $response = $this->actingAsUser()->postJson('/admin/rooms/rooms', [
            'building_id' => $building->id,
            'room_no' => 'R'.uniqid(),
            'room_type' => 'classroom',
            'capacity' => 30,
            'monthly_price' => 50,
            'status' => 'available',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Room created successfully.');
    }

    public function test_fee_type_can_be_created()
    {
        $response = $this->actingAsUser()->postJson('/admin/fees/types', [
            'name' => 'Tuition Fee '.uniqid(),
            'amount' => 100,
            'status' => 'active',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Fee type created successfully.');
    }

    public function test_fee_type_can_be_updated()
    {
        $feeType = FeeType::first();
        if (! $feeType) {
            $feeType = FeeType::create(['name' => 'Test Fee', 'amount' => 50, 'status' => 'active']);
        }
        $response = $this->actingAsUser()->putJson("/admin/fees/types/{$feeType->id}", [
            'name' => 'Updated Fee',
            'amount' => 150,
            'status' => 'active',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Fee type updated successfully.');
    }

    public function test_invoice_create_page_loads()
    {
        $response = $this->actingAsUser()->get('/admin/fees/invoices/create');
        $response->assertStatus(200);
    }

    public function test_payment_create_page_loads()
    {
        $response = $this->actingAsUser()->get('/admin/fees/payments/create');
        $response->assertStatus(200);
    }

    public function test_class_schedule_page_loads()
    {
        $course = Course::first();
        $level = Level::where('course_id', $course->id)->first();
        $year = AcademicYear::first();
        $shift = Shift::first();
        $class = ClassModel::create([
            'class_code' => 'SCH-TEST',
            'course_id' => $course->id,
            'level_id' => $level?->id,
            'academic_year_id' => $year?->id,
            'shift_id' => $shift?->id,
            'status' => 'active',
        ]);
        $response = $this->actingAsUser()->get("/admin/classes/{$class->id}/schedules");
        $response->assertStatus(200);
    }
}
