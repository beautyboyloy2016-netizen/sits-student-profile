<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'code', 'name_kh', 'name_en', 'address',
        'phone', 'email', 'logo_path', 'is_main', 'status', 'sort_order',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user');
    }
}
