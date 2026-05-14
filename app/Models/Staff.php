<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff';

    protected $fillable = ['branch_id', 'staff_code', 'name_kh', 'name_en', 'gender_id', 'phone', 'email', 'position', 'status', 'user_id'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function gender() { return $this->belongsTo(Gender::class); }


    public function user() { return $this->belongsTo(User::class); }


    public function classes() { return $this->hasMany(ClassModel::class, 'teacher_id'); }

}
