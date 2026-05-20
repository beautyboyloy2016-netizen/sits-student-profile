<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';

    protected $fillable = ['name', 'description', 'status'];

    public function levels() { return $this->hasMany(Level::class); }


    public function classes() { return $this->hasMany(ClassModel::class); }


    public function diplomas() { return $this->hasMany(StudentDiploma::class); }

}
