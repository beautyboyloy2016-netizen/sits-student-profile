<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentUpdateRequest extends Model
{
    use HasFactory;

    protected $table = 'student_update_requests';

    protected $fillable = ['student_id', 'requested_by', 'field_name', 'old_value', 'new_value', 'reason', 'status', 'approved_by', 'approved_at'];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function student() { return $this->belongsTo(Student::class); }


    public function requester() { return $this->belongsTo(User::class, 'requested_by'); }


    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

}
