<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('report_logs') || DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE report_logs MODIFY COLUMN report_type ENUM(
            'student_card_report',
            'certificate_report',
            'diploma_report',
            'student_report',
            'payment_report',
            'enrollment_report',
            'class_report',
            'room_report',
            'user_report',
            'audit_log_report',
            'students_master_list',
            'new_admissions',
            'class_roster',
            'monthly_attendance',
            'daily_cash_receipts',
            'ar_aging',
            'revenue',
            'fee_statement'
        ) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('report_logs') || DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE report_logs MODIFY COLUMN report_type ENUM(
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
        ) NOT NULL");
    }
};
