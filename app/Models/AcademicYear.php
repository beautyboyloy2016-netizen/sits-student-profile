<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicYear extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'academic_years';

    protected $fillable = ['branch_id', 'name', 'start_date', 'end_date', 'is_current', 'status'];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function classes() { return $this->hasMany(ClassModel::class); }


    public function enrollments() { return $this->hasMany(Enrollment::class); }

}
