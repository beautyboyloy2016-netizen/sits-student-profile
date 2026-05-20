<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $fillable = ['course_id', 'name', 'sort_order'];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function course() { return $this->belongsTo(Course::class); }


    public function classes() { return $this->hasMany(ClassModel::class); }

}
