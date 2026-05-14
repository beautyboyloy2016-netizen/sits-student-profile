<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentDiploma extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_diplomas';

    protected $fillable = ['diploma_no', 'student_id', 'course_id', 'level_id', 'class_id', 'enrollment_id', 'template_id', 'graduation_date', 'issue_date', 'grade', 'gpa', 'description', 'status', 'approved_by', 'approved_at', 'issued_by', 'printed_at', 'print_count', 'created_by', 'updated_by'];

    public function student() { return $this->belongsTo(Student::class); }


    public function course() { return $this->belongsTo(Course::class); }


    public function level() { return $this->belongsTo(Level::class); }


    public function class() { return $this->belongsTo(ClassModel::class); }


    public function template() { return $this->belongsTo(PrintTemplate::class); }

}
