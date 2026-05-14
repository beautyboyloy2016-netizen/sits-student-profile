<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchSettingController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ExportLogController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FileAccessLogController;
use App\Http\Controllers\FileProtectionRuleController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrintLogController;
use App\Http\Controllers\PrintTemplateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportLogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentCardController;
use App\Http\Controllers\StudentCertificateController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDiplomaController;
use App\Http\Controllers\StudentFileController;
use App\Http\Controllers\StudentRoomAssignmentController;
use App\Http\Controllers\StudentUpdateRequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Language switcher (redirect version)
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'km'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back()->withHeaders(['Vary' => 'Accept-Language']);
})->name('lang.switch');

// Language switcher AJAX (no page refresh)
Route::post('/lang/{locale}/ajax', function (string $locale) {
    if (in_array($locale, ['en', 'km'])) {
        session(['locale' => $locale]);

        return response()->json(['success' => true, 'locale' => $locale]);
    }

    return response()->json(['success' => false], 422);
})->name('lang.switch.ajax');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (no permission required, self-service)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Branches
    Route::post('/admin/branches/switch', [BranchController::class, 'switchBranch'])->middleware('can:branches.switch')->name('branches.switch');
    Route::get('/admin/branches', [BranchController::class, 'index'])->middleware('can:branches.view')->name('branches.index');
    Route::get('/admin/branches/create', [BranchController::class, 'create'])->middleware('can:branches.create')->name('branches.create');
    Route::post('/admin/branches', [BranchController::class, 'store'])->middleware('can:branches.create')->name('branches.store');
    Route::get('/admin/branches/{branch}/edit', [BranchController::class, 'edit'])->middleware('can:branches.edit')->name('branches.edit');
    Route::put('/admin/branches/{branch}', [BranchController::class, 'update'])->middleware('can:branches.edit')->name('branches.update');
    Route::delete('/admin/branches/{branch}', [BranchController::class, 'destroy'])->middleware('can:branches.delete')->name('branches.destroy');

    // Branch Settings
    Route::get('/admin/branches/{branch}/settings', [BranchSettingController::class, 'edit'])->middleware('can:branch_settings.view')->name('branch-settings.edit');
    Route::put('/admin/branches/{branch}/settings', [BranchSettingController::class, 'update'])->middleware('can:branch_settings.edit')->name('branch-settings.update');

    // Attendances
    Route::get('/admin/attendances', [AttendanceController::class, 'index'])->middleware('can:attendances.view')->name('attendances.index');
    Route::post('/admin/attendances', [AttendanceController::class, 'store'])->middleware('can:attendances.create')->name('attendances.store');
    Route::post('/admin/attendances/bulk', [AttendanceController::class, 'bulkStore'])->middleware('can:attendances.create')->name('attendances.bulk-store');
    Route::put('/admin/attendances/{attendance}', [AttendanceController::class, 'update'])->middleware('can:attendances.edit')->name('attendances.update');
    Route::delete('/admin/attendances/{attendance}', [AttendanceController::class, 'destroy'])->middleware('can:attendances.delete')->name('attendances.destroy');

    // Students
    Route::get('/admin/students', [StudentController::class, 'index'])->middleware('can:students.view')->name('students.index');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->middleware('can:students.create')->name('students.create');
    Route::post('/admin/students', [StudentController::class, 'store'])->middleware('can:students.create')->name('students.store');
    Route::get('/admin/students/{student}', [StudentController::class, 'show'])->middleware('can:students.view')->name('students.show');
    Route::get('/admin/students/{student}/edit', [StudentController::class, 'edit'])->middleware('can:students.edit')->name('students.edit');
    Route::put('/admin/students/{student}', [StudentController::class, 'update'])->middleware('can:students.edit')->name('students.update');
    Route::patch('/admin/students/{student}', [StudentController::class, 'update'])->middleware('can:students.edit');
    Route::delete('/admin/students/{student}', [StudentController::class, 'destroy'])->middleware('can:students.delete')->name('students.destroy');

    // Global student sub-resource listings
    Route::get('/admin/student-cards', [StudentCardController::class, 'globalIndex'])->middleware('can:cards.view')->name('student-cards.index');
    Route::post('/admin/student-cards/bulk-print', [StudentCardController::class, 'bulkPrint'])->middleware('can:cards.view')->name('student-cards.bulk-print');
    Route::get('/admin/student-certificates', [StudentCertificateController::class, 'globalIndex'])->middleware('can:certificates.view')->name('student-certificates.index');
    Route::get('/admin/student-diplomas', [StudentDiplomaController::class, 'globalIndex'])->middleware('can:diplomas.view')->name('student-diplomas.index');
    Route::get('/admin/student-files', [StudentFileController::class, 'globalIndex'])->middleware('can:student_files.view')->name('student-files.index');
    Route::get('/admin/student-room-assignments', [StudentRoomAssignmentController::class, 'globalIndex'])->middleware('can:student_room_assignments.view')->name('student-room-assignments.index');
    Route::get('/admin/student-update-requests', [StudentUpdateRequestController::class, 'globalIndex'])->middleware('can:student_update_requests.view')->name('student-update-requests.index');

    // Student Files
    Route::get('/admin/students/{student}/files', [StudentFileController::class, 'index'])->middleware('can:student_files.view')->name('students.files.index');
    Route::post('/admin/students/{student}/files', [StudentFileController::class, 'store'])->middleware('can:student_files.create')->name('students.files.store');
    Route::get('/admin/students/{student}/files/{file}/download', [StudentFileController::class, 'download'])->middleware('can:student_files.view')->name('students.files.download');
    Route::put('/admin/students/{student}/files/{file}', [StudentFileController::class, 'update'])->middleware('can:student_files.edit')->name('students.files.update');
    Route::delete('/admin/students/{student}/files/{file}', [StudentFileController::class, 'destroy'])->middleware('can:student_files.delete')->name('students.files.destroy');

    // Student Room Assignments
    Route::get('/admin/students/{student}/room-assignments', [StudentRoomAssignmentController::class, 'index'])->middleware('can:student_room_assignments.view')->name('students.room-assignments.index');
    Route::post('/admin/students/{student}/room-assignments', [StudentRoomAssignmentController::class, 'store'])->middleware('can:student_room_assignments.create')->name('students.room-assignments.store');
    Route::put('/admin/students/{student}/room-assignments/{assignment}', [StudentRoomAssignmentController::class, 'update'])->middleware('can:student_room_assignments.edit')->name('students.room-assignments.update');
    Route::delete('/admin/students/{student}/room-assignments/{assignment}', [StudentRoomAssignmentController::class, 'destroy'])->middleware('can:student_room_assignments.delete')->name('students.room-assignments.destroy');

    // Student Cards
    Route::get('/admin/students/{student}/cards', [StudentCardController::class, 'index'])->middleware('can:cards.view')->name('students.cards.index');
    Route::post('/admin/students/{student}/cards', [StudentCardController::class, 'store'])->middleware('can:cards.create')->name('students.cards.store');
    Route::put('/admin/students/{student}/cards/{card}', [StudentCardController::class, 'update'])->middleware('can:cards.edit')->name('students.cards.update');
    Route::get('/admin/students/{student}/cards/{card}/print', [StudentCardController::class, 'print'])->middleware('can:cards.view')->name('students.cards.print');
    Route::delete('/admin/students/{student}/cards/{card}', [StudentCardController::class, 'destroy'])->middleware('can:cards.delete')->name('students.cards.destroy');

    // Student Certificates
    Route::get('/admin/students/{student}/certificates', [StudentCertificateController::class, 'index'])->middleware('can:certificates.view')->name('students.certificates.index');
    Route::post('/admin/students/{student}/certificates', [StudentCertificateController::class, 'store'])->middleware('can:certificates.create')->name('students.certificates.store');
    Route::put('/admin/students/{student}/certificates/{certificate}', [StudentCertificateController::class, 'update'])->middleware('can:certificates.edit')->name('students.certificates.update');
    Route::get('/admin/students/{student}/certificates/{certificate}/print', [StudentCertificateController::class, 'print'])->middleware('can:certificates.view')->name('students.certificates.print');
    Route::post('/admin/students/{student}/certificates/{certificate}/approve', [StudentCertificateController::class, 'approve'])->middleware('can:certificates.approve')->name('students.certificates.approve');
    Route::delete('/admin/students/{student}/certificates/{certificate}', [StudentCertificateController::class, 'destroy'])->middleware('can:certificates.delete')->name('students.certificates.destroy');

    // Student Diplomas
    Route::get('/admin/students/{student}/diplomas', [StudentDiplomaController::class, 'index'])->middleware('can:diplomas.view')->name('students.diplomas.index');
    Route::post('/admin/students/{student}/diplomas', [StudentDiplomaController::class, 'store'])->middleware('can:diplomas.create')->name('students.diplomas.store');
    Route::put('/admin/students/{student}/diplomas/{diploma}', [StudentDiplomaController::class, 'update'])->middleware('can:diplomas.edit')->name('students.diplomas.update');
    Route::get('/admin/students/{student}/diplomas/{diploma}/print', [StudentDiplomaController::class, 'print'])->middleware('can:diplomas.view')->name('students.diplomas.print');
    Route::post('/admin/students/{student}/diplomas/{diploma}/approve', [StudentDiplomaController::class, 'approve'])->middleware('can:diplomas.approve')->name('students.diplomas.approve');
    Route::delete('/admin/students/{student}/diplomas/{diploma}', [StudentDiplomaController::class, 'destroy'])->middleware('can:diplomas.delete')->name('students.diplomas.destroy');

    // Student Update Requests
    Route::get('/admin/students/{student}/update-requests', [StudentUpdateRequestController::class, 'index'])->middleware('can:student_update_requests.view')->name('students.update-requests.index');
    Route::post('/admin/students/{student}/update-requests', [StudentUpdateRequestController::class, 'store'])->middleware('can:student_update_requests.create')->name('students.update-requests.store');
    Route::post('/admin/students/{student}/update-requests/{updateRequest}/approve', [StudentUpdateRequestController::class, 'approve'])->middleware('can:student_update_requests.approve')->name('students.update-requests.approve');
    Route::post('/admin/students/{student}/update-requests/{updateRequest}/reject', [StudentUpdateRequestController::class, 'reject'])->middleware('can:student_update_requests.approve')->name('students.update-requests.reject');
    Route::delete('/admin/students/{student}/update-requests/{updateRequest}', [StudentUpdateRequestController::class, 'destroy'])->middleware('can:student_update_requests.delete')->name('students.update-requests.destroy');

    // Guardians
    Route::get('/admin/guardians', [GuardianController::class, 'index'])->middleware('can:guardians.view')->name('guardians.index');
    Route::get('/admin/guardians/create', [GuardianController::class, 'create'])->middleware('can:guardians.create')->name('guardians.create');
    Route::post('/admin/guardians', [GuardianController::class, 'store'])->middleware('can:guardians.create')->name('guardians.store');
    Route::get('/admin/guardians/{guardian}', [GuardianController::class, 'show'])->middleware('can:guardians.view')->name('guardians.show');
    Route::get('/admin/guardians/{guardian}/edit', [GuardianController::class, 'edit'])->middleware('can:guardians.edit')->name('guardians.edit');
    Route::put('/admin/guardians/{guardian}', [GuardianController::class, 'update'])->middleware('can:guardians.edit')->name('guardians.update');
    Route::patch('/admin/guardians/{guardian}', [GuardianController::class, 'update'])->middleware('can:guardians.edit');
    Route::delete('/admin/guardians/{guardian}', [GuardianController::class, 'destroy'])->middleware('can:guardians.delete')->name('guardians.destroy');

    // Courses
    Route::get('/admin/courses', [CourseController::class, 'index'])->middleware('can:courses.view')->name('courses.index');
    Route::post('/admin/courses', [CourseController::class, 'store'])->middleware('can:courses.create')->name('courses.store');
    Route::put('/admin/courses/{course}', [CourseController::class, 'update'])->middleware('can:courses.edit')->name('courses.update');
    Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy'])->middleware('can:courses.delete')->name('courses.destroy');
    Route::post('/admin/courses/levels', [CourseController::class, 'storeLevel'])->middleware('can:courses.create')->name('courses.levels.store');

    // Classes
    Route::get('/admin/classes', [ClassController::class, 'index'])->middleware('can:classes.view')->name('classes.index');
    Route::get('/admin/classes/create', [ClassController::class, 'create'])->middleware('can:classes.create')->name('classes.create');
    Route::post('/admin/classes', [ClassController::class, 'store'])->middleware('can:classes.create')->name('classes.store');
    Route::get('/admin/classes/{class}/edit', [ClassController::class, 'edit'])->middleware('can:classes.edit')->name('classes.edit');
    Route::put('/admin/classes/{class}', [ClassController::class, 'update'])->middleware('can:classes.edit')->name('classes.update');
    Route::delete('/admin/classes/{class}', [ClassController::class, 'destroy'])->middleware('can:classes.delete')->name('classes.destroy');

    // Class Schedules
    Route::get('/admin/classes/{class}/schedules', [ClassScheduleController::class, 'index'])->middleware('can:classes.view')->name('classes.schedules.index');
    Route::post('/admin/classes/{class}/schedules', [ClassScheduleController::class, 'store'])->middleware('can:classes.edit')->name('classes.schedules.store');
    Route::delete('/admin/classes/{class}/schedules/{schedule}', [ClassScheduleController::class, 'destroy'])->middleware('can:classes.edit')->name('classes.schedules.destroy');

    // Enrollments
    Route::get('/admin/enrollments', [EnrollmentController::class, 'index'])->middleware('can:enrollments.view')->name('enrollments.index');
    Route::get('/admin/enrollments/create', [EnrollmentController::class, 'create'])->middleware('can:enrollments.create')->name('enrollments.create');
    Route::post('/admin/enrollments', [EnrollmentController::class, 'store'])->middleware('can:enrollments.create')->name('enrollments.store');
    Route::get('/admin/enrollments/{enrollment}/edit', [EnrollmentController::class, 'edit'])->middleware('can:enrollments.edit')->name('enrollments.edit');
    Route::put('/admin/enrollments/{enrollment}', [EnrollmentController::class, 'update'])->middleware('can:enrollments.edit')->name('enrollments.update');
    Route::delete('/admin/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->middleware('can:enrollments.delete')->name('enrollments.destroy');

    // Academic Years
    Route::get('/admin/academic-years', [AcademicYearController::class, 'index'])->middleware('can:academic_years.view')->name('academic-years.index');
    Route::post('/admin/academic-years', [AcademicYearController::class, 'store'])->middleware('can:academic_years.create')->name('academic-years.store');
    Route::put('/admin/academic-years/{academic_year}', [AcademicYearController::class, 'update'])->middleware('can:academic_years.edit')->name('academic-years.update');
    Route::delete('/admin/academic-years/{academic_year}', [AcademicYearController::class, 'destroy'])->middleware('can:academic_years.delete')->name('academic-years.destroy');

    // Shifts
    Route::get('/admin/shifts', [ShiftController::class, 'index'])->middleware('can:shifts.view')->name('shifts.index');
    Route::post('/admin/shifts', [ShiftController::class, 'store'])->middleware('can:shifts.create')->name('shifts.store');
    Route::put('/admin/shifts/{shift}', [ShiftController::class, 'update'])->middleware('can:shifts.edit')->name('shifts.update');
    Route::delete('/admin/shifts/{shift}', [ShiftController::class, 'destroy'])->middleware('can:shifts.delete')->name('shifts.destroy');

    // Staff
    Route::get('/admin/staff', [StaffController::class, 'index'])->middleware('can:staff.view')->name('staff.index');
    Route::get('/admin/staff/create', [StaffController::class, 'create'])->middleware('can:staff.create')->name('staff.create');
    Route::post('/admin/staff', [StaffController::class, 'store'])->middleware('can:staff.create')->name('staff.store');
    Route::get('/admin/staff/{staff}', [StaffController::class, 'show'])->middleware('can:staff.view')->name('staff.show');
    Route::get('/admin/staff/{staff}/edit', [StaffController::class, 'edit'])->middleware('can:staff.edit')->name('staff.edit');
    Route::put('/admin/staff/{staff}', [StaffController::class, 'update'])->middleware('can:staff.edit')->name('staff.update');
    Route::patch('/admin/staff/{staff}', [StaffController::class, 'update'])->middleware('can:staff.edit');
    Route::delete('/admin/staff/{staff}', [StaffController::class, 'destroy'])->middleware('can:staff.delete')->name('staff.destroy');

    // Rooms / Buildings
    Route::get('/admin/rooms', [RoomController::class, 'index'])->middleware('can:rooms.view')->name('rooms.index');
    Route::post('/admin/rooms/buildings', [RoomController::class, 'storeBuilding'])->middleware('can:rooms.create')->name('rooms.buildings.store');
    Route::put('/admin/rooms/buildings/{building}', [RoomController::class, 'updateBuilding'])->middleware('can:rooms.edit')->name('rooms.buildings.update');
    Route::delete('/admin/rooms/buildings/{building}', [RoomController::class, 'destroyBuilding'])->middleware('can:rooms.delete')->name('rooms.buildings.destroy');
    Route::post('/admin/rooms/rooms', [RoomController::class, 'storeRoom'])->middleware('can:rooms.create')->name('rooms.store');
    Route::put('/admin/rooms/rooms/{room}', [RoomController::class, 'updateRoom'])->middleware('can:rooms.edit')->name('rooms.update');
    Route::delete('/admin/rooms/rooms/{room}', [RoomController::class, 'destroyRoom'])->middleware('can:rooms.delete')->name('rooms.destroy');

    // Fee Types
    Route::get('/admin/fees/types', [FeeController::class, 'feeTypes'])->middleware('can:fee_types.view')->name('fees.types');
    Route::post('/admin/fees/types', [FeeController::class, 'storeFeeType'])->middleware('can:fee_types.create')->name('fees.types.store');
    Route::put('/admin/fees/types/{feeType}', [FeeController::class, 'updateFeeType'])->middleware('can:fee_types.edit')->name('fees.types.update');
    Route::delete('/admin/fees/types/{feeType}', [FeeController::class, 'destroyFeeType'])->middleware('can:fee_types.delete')->name('fees.types.destroy');

    // Invoices
    Route::get('/admin/fees/invoices', [FeeController::class, 'invoices'])->middleware('can:invoices.view')->name('fees.invoices');
    Route::get('/admin/fees/invoices/create', [FeeController::class, 'createInvoice'])->middleware('can:invoices.create')->name('fees.invoices.create');
    Route::post('/admin/fees/invoices', [FeeController::class, 'storeInvoice'])->middleware('can:invoices.create')->name('fees.invoices.store');
    Route::get('/admin/fees/invoices/{invoice}', [FeeController::class, 'showInvoice'])->middleware('can:invoices.view')->name('fees.invoices.show');
    Route::get('/admin/fees/invoices/{invoice}/edit', [FeeController::class, 'editInvoice'])->middleware('can:invoices.edit')->name('fees.invoices.edit');
    Route::put('/admin/fees/invoices/{invoice}', [FeeController::class, 'updateInvoice'])->middleware('can:invoices.edit')->name('fees.invoices.update');

    // Payments
    Route::get('/admin/fees/payments', [FeeController::class, 'payments'])->middleware('can:payments.view')->name('fees.payments');
    Route::get('/admin/fees/payments/create', [FeeController::class, 'createPayment'])->middleware('can:payments.create')->name('fees.payments.create');
    Route::post('/admin/fees/payments', [FeeController::class, 'storePayment'])->middleware('can:payments.create')->name('fees.payments.store');
    Route::get('/admin/fees/payments/{payment}/edit', [FeeController::class, 'editPayment'])->middleware('can:payments.edit')->name('fees.payments.edit');
    Route::put('/admin/fees/payments/{payment}', [FeeController::class, 'updatePayment'])->middleware('can:payments.edit')->name('fees.payments.update');

    // Print Templates
    Route::get('/admin/print-templates', [PrintTemplateController::class, 'index'])->middleware('can:print_templates.view')->name('print-templates.index');
    Route::get('/admin/print-templates/create', [PrintTemplateController::class, 'create'])->middleware('can:print_templates.create')->name('print-templates.create');
    Route::post('/admin/print-templates', [PrintTemplateController::class, 'store'])->middleware('can:print_templates.create')->name('print-templates.store');
    Route::get('/admin/print-templates/{print_template}', [PrintTemplateController::class, 'show'])->middleware('can:print_templates.view')->name('print-templates.show');
    Route::get('/admin/print-templates/{print_template}/edit', [PrintTemplateController::class, 'edit'])->middleware('can:print_templates.edit')->name('print-templates.edit');
    Route::put('/admin/print-templates/{print_template}', [PrintTemplateController::class, 'update'])->middleware('can:print_templates.edit')->name('print-templates.update');
    Route::patch('/admin/print-templates/{print_template}', [PrintTemplateController::class, 'update'])->middleware('can:print_templates.edit');
    Route::delete('/admin/print-templates/{print_template}', [PrintTemplateController::class, 'destroy'])->middleware('can:print_templates.delete')->name('print-templates.destroy');

    // Logs
    Route::get('/admin/audit-logs', [AuditLogController::class, 'index'])->middleware('can:audit_logs.view')->name('audit-logs.index');
    Route::get('/admin/report-logs', [ReportLogController::class, 'index'])->middleware('can:report_logs.view')->name('report-logs.index');
    Route::post('/admin/report-logs', [ReportLogController::class, 'store'])->middleware('can:report_logs.create')->name('report-logs.store');
    Route::get('/admin/export-logs', [ExportLogController::class, 'index'])->middleware('can:export_logs.view')->name('export-logs.index');
    Route::get('/admin/print-logs', [PrintLogController::class, 'index'])->middleware('can:print_logs.view')->name('print-logs.index');
    Route::get('/admin/file-access-logs', [FileAccessLogController::class, 'index'])->middleware('can:file_access_logs.view')->name('file-access-logs.index');

    // Users
    Route::get('/admin/users', [UserController::class, 'index'])->middleware('can:users.view')->name('users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->middleware('can:users.create')->name('users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->middleware('can:users.create')->name('users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->middleware('can:users.edit')->name('users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->middleware('can:users.edit')->name('users.update');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->middleware('can:users.edit');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->middleware('can:users.delete')->name('users.destroy');

    // Roles
    Route::get('/admin/roles', [RoleController::class, 'index'])->middleware('can:roles.view')->name('roles.index');
    Route::post('/admin/roles', [RoleController::class, 'store'])->middleware('can:roles.create')->name('roles.store');
    Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->middleware('can:roles.edit')->name('roles.update');
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->middleware('can:roles.delete')->name('roles.destroy');

    // Permissions
    Route::get('/admin/permissions', [PermissionController::class, 'index'])->middleware('can:permissions.view')->name('permissions.index');
    Route::post('/admin/permissions', [PermissionController::class, 'store'])->middleware('can:permissions.create')->name('permissions.store');
    Route::put('/admin/permissions/{permission}', [PermissionController::class, 'update'])->middleware('can:permissions.edit')->name('permissions.update');
    Route::delete('/admin/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('can:permissions.delete')->name('permissions.destroy');

    // Genders
    Route::get('/admin/genders', [GenderController::class, 'index'])->middleware('can:genders.view')->name('genders.index');
    Route::post('/admin/genders', [GenderController::class, 'store'])->middleware('can:genders.create')->name('genders.store');
    Route::put('/admin/genders/{gender}', [GenderController::class, 'update'])->middleware('can:genders.edit')->name('genders.update');
    Route::delete('/admin/genders/{gender}', [GenderController::class, 'destroy'])->middleware('can:genders.delete')->name('genders.destroy');

    // Locations
    Route::get('/admin/locations', [LocationController::class, 'index'])->middleware('can:locations.view')->name('locations.index');
    Route::get('/admin/locations/tree', [LocationController::class, 'tree'])->middleware('can:locations.view')->name('locations.tree');
    Route::post('/admin/locations/provinces', [LocationController::class, 'storeProvince'])->middleware('can:locations.create')->name('locations.provinces.store');
    Route::put('/admin/locations/provinces/{province}', [LocationController::class, 'updateProvince'])->middleware('can:locations.edit')->name('locations.provinces.update');
    Route::delete('/admin/locations/provinces/{province}', [LocationController::class, 'destroyProvince'])->middleware('can:locations.delete')->name('locations.provinces.destroy');
    Route::post('/admin/locations/districts', [LocationController::class, 'storeDistrict'])->middleware('can:locations.create')->name('locations.districts.store');
    Route::put('/admin/locations/districts/{district}', [LocationController::class, 'updateDistrict'])->middleware('can:locations.edit')->name('locations.districts.update');
    Route::delete('/admin/locations/districts/{district}', [LocationController::class, 'destroyDistrict'])->middleware('can:locations.delete')->name('locations.districts.destroy');
    Route::post('/admin/locations/communes', [LocationController::class, 'storeCommune'])->middleware('can:locations.create')->name('locations.communes.store');
    Route::put('/admin/locations/communes/{commune}', [LocationController::class, 'updateCommune'])->middleware('can:locations.edit')->name('locations.communes.update');
    Route::delete('/admin/locations/communes/{commune}', [LocationController::class, 'destroyCommune'])->middleware('can:locations.delete')->name('locations.communes.destroy');
    Route::post('/admin/locations/villages', [LocationController::class, 'storeVillage'])->middleware('can:locations.create')->name('locations.villages.store');
    Route::put('/admin/locations/villages/{village}', [LocationController::class, 'updateVillage'])->middleware('can:locations.edit')->name('locations.villages.update');
    Route::delete('/admin/locations/villages/{village}', [LocationController::class, 'destroyVillage'])->middleware('can:locations.delete')->name('locations.villages.destroy');

    // ── Reports ─────────────────────────────────────────────────────
    Route::prefix('admin/reports')->name('reports.')->middleware('can:reports.view')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/students', [ReportController::class, 'students'])->name('students');
        Route::get('/students/export', [ReportController::class, 'studentsExport'])->middleware('can:reports.export')->name('students.export');
        Route::get('/new-admissions', [ReportController::class, 'newAdmissions'])->name('new_admissions');
        Route::get('/class-roster', [ReportController::class, 'classRoster'])->name('class_roster');
        Route::get('/monthly-attendance', [ReportController::class, 'monthlyAttendance'])->name('monthly_attendance');
        Route::get('/daily-cash-receipts', [ReportController::class, 'dailyCashReceipts'])->name('daily_cash_receipts');
        Route::get('/ar-aging', [ReportController::class, 'arAging'])->name('ar_aging');
        Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('/fee-statement', [ReportController::class, 'feeStatement'])->name('fee_statement');
    });

    // File Protection
    Route::get('/admin/file-protection-rules', [FileProtectionRuleController::class, 'index'])->middleware('can:file_protection_rules.view')->name('file-protection-rules.index');
    Route::post('/admin/file-protection-rules', [FileProtectionRuleController::class, 'store'])->middleware('can:file_protection_rules.create')->name('file-protection-rules.store');
    Route::put('/admin/file-protection-rules/{rule}', [FileProtectionRuleController::class, 'update'])->middleware('can:file_protection_rules.edit')->name('file-protection-rules.update');
    Route::delete('/admin/file-protection-rules/{rule}', [FileProtectionRuleController::class, 'destroy'])->middleware('can:file_protection_rules.delete')->name('file-protection-rules.destroy');
});

require __DIR__.'/auth.php';
