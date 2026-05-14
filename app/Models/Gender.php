<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Gender extends Model
{
    use HasFactory;

    protected $table = 'genders';

    protected $fillable = ['name_kh', 'name_en', 'sort_order'];
}
