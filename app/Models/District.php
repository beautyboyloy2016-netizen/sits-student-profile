<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = ['type', 'code', 'province_id', 'name_kh', 'name_en'];

    public function province() { return $this->belongsTo(Province::class); }

    public function communes() { return $this->hasMany(Commune::class); }

    public function villages() { return $this->hasMany(Village::class); }
}
