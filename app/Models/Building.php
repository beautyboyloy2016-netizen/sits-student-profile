<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'buildings';

    protected $fillable = ['branch_id', 'name', 'address_id', 'status'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function address() { return $this->belongsTo(Address::class); }


    public function rooms() { return $this->hasMany(Room::class); }

}
