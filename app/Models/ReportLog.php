<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ReportLog extends Model
{
    use HasFactory;

    public const TYPES = [
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
        'fee_statement',
    ];

    protected $table = 'report_logs';

    protected $fillable = ['branch_id', 'report_type', 'report_title', 'filters', 'file_path', 'export_format', 'generated_by', 'generated_at'];

    protected $casts = [
        'filters'      => 'array',
        'generated_at' => 'datetime',
    ];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function generator() { return $this->belongsTo(User::class, 'generated_by'); }
}
