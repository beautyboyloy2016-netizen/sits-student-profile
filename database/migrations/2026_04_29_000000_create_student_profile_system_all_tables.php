<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 0. Branches
        |--------------------------------------------------------------------------
        */

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Short code e.g. MAIN, PP, SR');
            $table->string('name_kh');
            $table->string('name_en');
            $table->string('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('is_main')->default(false)->comment('Marks the head / main campus');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | 1. Users / Roles / Permissions
        |--------------------------------------------------------------------------
        */

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('photo')->nullable();
            $table->string('password');
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('module');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'role_id']);
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['permission_id', 'role_id']);
        });

        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['permission_id', 'user_id']);
        });

        // Pivot: a user may be assigned to multiple branches
        Schema::create('branch_user', function (Blueprint $table) {
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['branch_id', 'user_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | 2. Location Tables
        |--------------------------------------------------------------------------
        */

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->string('name_kh');
            $table->string('name_en')->nullable();
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('province_id')->constrained('provinces')->cascadeOnDelete();
            $table->string('name_kh');
            $table->string('name_en')->nullable();
            $table->timestamps();
        });

        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('province_id')->constrained('provinces')->cascadeOnDelete();
            $table->foreignId('district_id')->constrained('districts')->cascadeOnDelete();
            $table->string('name_kh');
            $table->string('name_en')->nullable();
            $table->timestamps();
        });

        Schema::create('villages', function (Blueprint $table) {
          $table->id();
          $table->string('type')->nullable();
          $table->string('code')->nullable();
          $table->string('name_kh')->nullable();
          $table->string('name_en')->nullable();
          $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
          $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
          $table->foreignId('commune_id')->nullable()->constrained('communes')->nullOnDelete();
          $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('commune_id')->nullable()->constrained('communes')->nullOnDelete();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
            $table->string('street')->nullable();
            $table->string('house_no')->nullable();
            $table->text('full_address')->nullable();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | 3. Basic Data
        |--------------------------------------------------------------------------
        */

        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name_kh');
            $table->string('name_en');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | 4. Staff / Teacher
        |--------------------------------------------------------------------------
        */

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('staff_code');
            $table->string('name_kh');
            $table->string('name_en')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('position')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'staff_code']); // unique per branch
        });

        /*
        |--------------------------------------------------------------------------
        | 5. Students
        |--------------------------------------------------------------------------
        */

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('student_code')->unique();
            $table->string('khmer_name');
            $table->string('latin_name')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();
            $table->date('date_of_birth')->nullable();
            $table->foreignId('birth_place_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('current_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo_path')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated', 'suspended', 'dropped'])->default('active');
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('khmer_name');
            $table->index('latin_name');
            $table->index('phone');
            $table->index('status');
        });

        /*
        |--------------------------------------------------------------------------
        | 6. Guardians / Parents
        |--------------------------------------------------------------------------
        */

        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('name_kh');
            $table->string('name_en')->nullable();
            $table->string('phone')->nullable();
            $table->string('occupation')->nullable();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('phone');
        });

        Schema::create('student_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained('guardians')->cascadeOnDelete();
            $table->string('relationship')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->unique(['student_id', 'guardian_id']);
        });

        /*
        |--------------------------------------------------------------------------
        | 7. Course / Level / Academic Year / Shift
        |--------------------------------------------------------------------------
        */

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->enum('status', ['active', 'inactive', 'closed'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'name']); // unique per branch, not global
        });

        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        /*
        |--------------------------------------------------------------------------
        | 8. Building / Room
        |--------------------------------------------------------------------------
        */

        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->nullable()->constrained('buildings')->nullOnDelete();
            $table->string('room_no');
            $table->enum('room_type', ['single', 'double', 'shared', 'classroom'])->default('classroom');
            $table->integer('capacity')->default(0);
            $table->decimal('monthly_price', 12, 2)->default(0);
            $table->enum('status', ['available', 'full', 'maintenance', 'inactive'])->default('available');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['building_id', 'room_no']);
        });

        /*
        |--------------------------------------------------------------------------
        | 9. Class / Schedule / Enrollment
        |--------------------------------------------------------------------------
        */

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('class_code');
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['branch_id', 'class_code']); // unique per branch
            $table->index(['course_id', 'level_id']);
            $table->index(['academic_year_id', 'shift_id']);
        });

        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->enum('day_of_week', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ]);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->index(['class_id', 'day_of_week']);
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->date('enroll_date')->nullable();
            $table->string('study_time_label')->nullable();
            $table->enum('status', ['studying', 'completed', 'dropped', 'transferred'])->default('studying');
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['student_id', 'class_id']);
            $table->index('status');
        });

        /*
        |--------------------------------------------------------------------------
        | 10. Student Room Assignment
        |--------------------------------------------------------------------------
        */

        Schema::create('student_room_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->enum('status', ['active', 'checked_out', 'cancelled'])->default('active');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'room_id']);
            $table->index('status');
        });

        /*
        |--------------------------------------------------------------------------
        | 11. Student Files / Upload Image
        |--------------------------------------------------------------------------
        */

        Schema::create('student_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->enum('file_type', [
                'photo',
                'birth_certificate',
                'id_card',
                'certificate',
                'diploma',
                'document',
                'other'
            ])->default('document');
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'file_type']);
        });

        /*
        |--------------------------------------------------------------------------
        | 12. Print Templates
        |--------------------------------------------------------------------------
        */

        Schema::create('print_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->enum('template_type', ['student_card', 'certificate', 'diploma']);
            $table->string('paper_size')->default('A4');
            $table->enum('orientation', ['portrait', 'landscape'])->default('portrait');
            $table->longText('html_template')->nullable();
            $table->longText('css_template')->nullable();
            $table->json('settings')->nullable();
            $table->boolean('is_default')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['branch_id', 'template_type', 'status']);
        });

        /*
        |--------------------------------------------------------------------------
        | 13. Student Cards
        |--------------------------------------------------------------------------
        */

        Schema::create('student_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('print_templates')->nullOnDelete();
            $table->string('card_no')->unique();
            $table->date('issue_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('status', ['active', 'expired', 'lost', 'cancelled'])->default('active');
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('printed_at')->nullable();
            $table->integer('print_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'status']);
            $table->index('template_id');
        });

        /*
        |--------------------------------------------------------------------------
        | 14. Student Certificates
        |--------------------------------------------------------------------------
        */

        Schema::create('student_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_no')->unique();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->foreignId('enrollment_id')->nullable()->constrained('enrollments')->nullOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('print_templates')->nullOnDelete();
            $table->enum('certificate_type', [
                'appreciation',
                'achievement',
                'participation',
                'completion',
                'excellent_student',
                'other'
            ])->default('appreciation');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('issue_date')->nullable();
            $table->enum('status', ['draft', 'approved', 'printed', 'cancelled'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('printed_at')->nullable();
            $table->integer('print_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'status']);
            $table->index(['certificate_type', 'issue_date']);
            $table->index('template_id');
        });

        /*
        |--------------------------------------------------------------------------
        | 15. Student Diplomas
        |--------------------------------------------------------------------------
        */

        Schema::create('student_diplomas', function (Blueprint $table) {
            $table->id();
            $table->string('diploma_no')->unique();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->foreignId('enrollment_id')->nullable()->constrained('enrollments')->nullOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('print_templates')->nullOnDelete();
            $table->date('graduation_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('grade')->nullable();
            $table->decimal('gpa', 4, 2)->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'approved', 'printed', 'cancelled'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('printed_at')->nullable();
            $table->integer('print_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'status']);
            $table->index(['course_id', 'level_id']);
            $table->index('issue_date');
            $table->index('template_id');
        });

        /*
        |--------------------------------------------------------------------------
        | 16. Fee / Invoice / Payment
        |--------------------------------------------------------------------------
        */

        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->index('branch_id');
        });

        Schema::create('student_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('invoice_no')->unique();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->enum('status', ['unpaid', 'partial', 'paid', 'cancelled'])->default('unpaid');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'status']);
        });

        Schema::create('student_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('student_invoices')->cascadeOnDelete();
            $table->foreignId('fee_type_id')->nullable()->constrained('fee_types')->nullOnDelete();
            $table->string('description')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('payment_no')->unique();
            $table->foreignId('invoice_id')->nullable()->constrained('student_invoices')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('payment_date')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('payment_method', ['cash', 'bank', 'aba', 'wing', 'other'])->default('cash');
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['student_id', 'payment_date']);
        });

        /*
        |--------------------------------------------------------------------------
        | 17. Request To Update
        |--------------------------------------------------------------------------
        */

        Schema::create('student_update_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('field_name');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'status']);
        });

        /*
        |--------------------------------------------------------------------------
        | 18. Print Logs
        |--------------------------------------------------------------------------
        */

        Schema::create('print_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('printable_type', ['student_card', 'certificate', 'diploma']);
            $table->unsignedBigInteger('printable_id');
            $table->foreignId('template_id')->nullable()->constrained('print_templates')->nullOnDelete();
            $table->foreignId('printed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('printed_at')->nullable();
            $table->string('printer_name')->nullable();
            $table->integer('copies')->default(1);
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['printable_type', 'printable_id']);
            $table->index('printed_at');
        });

        /*
        |--------------------------------------------------------------------------
        | 19. Report Logs
        |--------------------------------------------------------------------------
        */

        Schema::create('report_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->enum('report_type', [
                'student_card_report',
                'certificate_report',
                'diploma_report',
                'student_report',
                'payment_report',
                'enrollment_report',
                'class_report',
                'room_report',
                'user_report',
                'audit_log_report'
            ]);
            $table->string('report_title')->nullable();
            $table->json('filters')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('export_format', ['pdf', 'excel', 'csv', 'print', 'view'])->default('view');
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['report_type', 'generated_at']);
        });

        /*
        |--------------------------------------------------------------------------
        | 20. Export Logs
        |--------------------------------------------------------------------------
        */

        Schema::create('export_logs', function (Blueprint $table) {
            $table->id();
            $table->string('export_type');
            $table->string('file_path')->nullable();
            $table->json('filter_data')->nullable();
            $table->foreignId('exported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('exported_at')->nullable();
            $table->timestamps();

            $table->index('export_type');
        });

        /*
        |--------------------------------------------------------------------------
        | 21. Audit Logs
        |--------------------------------------------------------------------------
        */

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('table_name');
            $table->unsignedBigInteger('record_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['table_name', 'record_id']);
            $table->index('action');
        });

        /*
        |--------------------------------------------------------------------------
        | 22. File Protection
        |--------------------------------------------------------------------------
        */

        Schema::create('file_protection_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('module')->nullable();
            $table->boolean('allow_download')->default(false);
            $table->boolean('allow_print')->default(false);
            $table->boolean('allow_export')->default(false);
            $table->boolean('watermark_enabled')->default(true);
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('file_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('student_file_id')->nullable()->constrained('student_files')->nullOnDelete();
            $table->string('action');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'action']);
        });

        /*
        |--------------------------------------------------------------------------
        | 23. Branch Settings (per-branch school configuration)
        |--------------------------------------------------------------------------
        */

        Schema::create('branch_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->string('school_name_kh')->nullable();
            $table->string('school_name_en')->nullable();
            $table->string('school_logo_path')->nullable();
            $table->string('school_stamp_path')->nullable();
            $table->string('school_signature_path')->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('ministry_registration_no')->nullable();
            $table->string('facebook_page')->nullable();
            $table->json('extra_settings')->nullable();
            $table->timestamps();

            $table->unique('branch_id'); // one setting row per branch
        });

        /*
        |--------------------------------------------------------------------------
        | 24. Attendances (Student & Staff)
        |--------------------------------------------------------------------------
        */

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->enum('attendable_type', ['student', 'staff']);
            $table->unsignedBigInteger('attendable_id');
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('present');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['attendable_type', 'attendable_id']);
            $table->index(['branch_id', 'date']);
            $table->index(['class_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('branch_settings');

        Schema::dropIfExists('file_access_logs');
        Schema::dropIfExists('file_protection_rules');

        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('export_logs');
        Schema::dropIfExists('report_logs');
        Schema::dropIfExists('print_logs');

        Schema::dropIfExists('student_update_requests');

        Schema::dropIfExists('payments');
        Schema::dropIfExists('student_invoice_items');
        Schema::dropIfExists('student_invoices');
        Schema::dropIfExists('fee_types');

        Schema::dropIfExists('student_diplomas');
        Schema::dropIfExists('student_certificates');
        Schema::dropIfExists('student_cards');
        Schema::dropIfExists('print_templates');

        Schema::dropIfExists('student_files');
        Schema::dropIfExists('student_room_assignments');

        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('class_schedules');
        Schema::dropIfExists('classes');

        Schema::dropIfExists('rooms');
        Schema::dropIfExists('buildings');

        Schema::dropIfExists('shifts');
        Schema::dropIfExists('academic_years');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('courses');

        Schema::dropIfExists('student_guardians');
        Schema::dropIfExists('guardians');
        Schema::dropIfExists('students');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('genders');

        Schema::dropIfExists('addresses');
        Schema::dropIfExists('communes');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');

        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('branch_user');
        Schema::dropIfExists('users');
        Schema::dropIfExists('branches');
    }
};
