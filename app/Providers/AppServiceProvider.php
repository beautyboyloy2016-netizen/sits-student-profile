<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\PrintTemplate;
use App\Models\Role;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentCard;
use App\Models\StudentCertificate;
use App\Models\StudentDiploma;
use App\Models\StudentFile;
use App\Models\StudentInvoice;
use App\Models\User;
use App\Observers\AuditObserver;
use App\Policies\EnrollmentPolicy;
use App\Policies\FeePolicy;
use App\Policies\PrintTemplatePolicy;
use App\Policies\RolePolicy;
use App\Policies\StudentCardPolicy;
use App\Policies\StudentCertificatePolicy;
use App\Policies\StudentDiplomaPolicy;
use App\Policies\StudentFilePolicy;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Student::observe(AuditObserver::class);
        Enrollment::observe(AuditObserver::class);
        Attendance::observe(AuditObserver::class);
        StudentCard::observe(AuditObserver::class);
        StudentCertificate::observe(AuditObserver::class);
        StudentDiploma::observe(AuditObserver::class);
        StudentInvoice::observe(AuditObserver::class);
        Payment::observe(AuditObserver::class);
        Staff::observe(AuditObserver::class);
        User::observe(AuditObserver::class);

        Gate::policy(Student::class, StudentPolicy::class);
        Gate::policy(Enrollment::class, EnrollmentPolicy::class);
        Gate::policy(StudentCard::class, StudentCardPolicy::class);
        Gate::policy(StudentCertificate::class, StudentCertificatePolicy::class);
        Gate::policy(StudentDiploma::class, StudentDiplomaPolicy::class);
        Gate::policy(StudentFile::class, StudentFilePolicy::class);
        Gate::policy(StudentInvoice::class, FeePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(PrintTemplate::class, PrintTemplatePolicy::class);
    }
}
