<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCertificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_certificates';

    protected $fillable = ['certificate_no', 'student_id', 'class_id', 'enrollment_id', 'template_id', 'certificate_type', 'title', 'description', 'issue_date', 'status', 'approved_by', 'approved_at', 'issued_by', 'printed_at', 'print_count', 'created_by', 'updated_by'];

    protected $casts = [
        'issue_date'  => 'date',
        'approved_at' => 'datetime',
        'printed_at'  => 'datetime',
        'print_count' => 'integer',
    ];

    public function student() { return $this->belongsTo(Student::class); }


    public function class() { return $this->belongsTo(ClassModel::class); }


    public function enrollment() { return $this->belongsTo(Enrollment::class); }


    public function template() { return $this->belongsTo(PrintTemplate::class); }


    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }


    public function issuer() { return $this->belongsTo(User::class, 'issued_by'); }

}
