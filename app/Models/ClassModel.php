<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = ['branch_id', 'class_code', 'course_id', 'level_id', 'academic_year_id', 'shift_id', 'teacher_id', 'room_id', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function course() { return $this->belongsTo(Course::class); }


    public function level() { return $this->belongsTo(Level::class); }


    public function academicYear() { return $this->belongsTo(AcademicYear::class); }


    public function shift() { return $this->belongsTo(Shift::class); }


    public function teacher() { return $this->belongsTo(Staff::class, 'teacher_id'); }


    public function room() { return $this->belongsTo(Room::class); }


    public function schedules() { return $this->hasMany(ClassSchedule::class, 'class_id'); }


    public function enrollments() { return $this->hasMany(Enrollment::class, 'class_id'); }

}
