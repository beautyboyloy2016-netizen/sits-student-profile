<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentRoomAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_room_assignments';

    protected $fillable = ['student_id', 'room_id', 'check_in_date', 'check_out_date', 'status', 'note'];

    public function student() { return $this->belongsTo(Student::class); }


    public function room() { return $this->belongsTo(Room::class); }

}
