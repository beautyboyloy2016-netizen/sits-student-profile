<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $table = 'villages';

    protected $fillable = ['type', 'code', 'name_kh', 'name_en', 'province_id', 'district_id', 'commune_id'];

    public function province() { return $this->belongsTo(Province::class); }
    public function district() { return $this->belongsTo(District::class); }
    public function commune() { return $this->belongsTo(Commune::class); }
    public function addresses() { return $this->hasMany(Address::class); }
}
