<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';

    protected $fillable = ['building_id', 'room_no', 'room_type', 'capacity', 'monthly_price', 'status'];

    protected $casts = [
        'capacity'      => 'integer',
        'monthly_price' => 'decimal:2',
    ];

    public function building() { return $this->belongsTo(Building::class); }


    public function studentAssignments() { return $this->hasMany(StudentRoomAssignment::class); }

}
