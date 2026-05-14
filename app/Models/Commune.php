<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Commune extends Model
{
    use HasFactory;

    protected $table = 'communes';

    protected $fillable = ['type', 'code', 'province_id', 'district_id', 'name_kh', 'name_en'];

    public function province() { return $this->belongsTo(Province::class); }
    public function district() { return $this->belongsTo(District::class); }
    public function villages() { return $this->hasMany(Village::class); }
}
