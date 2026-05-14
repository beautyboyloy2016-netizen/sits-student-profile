<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected $fillable = ['code', 'name_kh', 'name_en'];

    public function districts() { return $this->hasMany(District::class); }
    public function communes() { return $this->hasMany(Commune::class); }
    public function villages() { return $this->hasMany(Village::class); }
}
