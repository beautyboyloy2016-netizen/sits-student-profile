<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shifts';

    protected $fillable = ['name', 'start_time', 'end_time', 'status'];

    public function classes() { return $this->hasMany(ClassModel::class); }


    public function enrollments() { return $this->hasMany(Enrollment::class); }

}
