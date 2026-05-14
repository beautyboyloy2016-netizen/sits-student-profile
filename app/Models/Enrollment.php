<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'enrollments';

    protected $fillable = ['branch_id', 'student_id', 'class_id', 'academic_year_id', 'shift_id', 'enroll_date', 'study_time_label', 'status', 'note', 'created_by'];

    public function branch() { return $this->belongsTo(Branch::class); }

    protected $casts = [
        'enroll_date' => 'date',
    ];

    public function student() { return $this->belongsTo(Student::class); }


    public function class() { return $this->belongsTo(ClassModel::class, 'class_id'); }


    public function academicYear() { return $this->belongsTo(AcademicYear::class); }


    public function shift() { return $this->belongsTo(Shift::class); }

}
