<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchSetting extends Model
{
    use HasFactory;

    protected $table = 'branch_settings';

    protected $fillable = [
        'branch_id',
        'school_name_kh',
        'school_name_en',
        'school_logo_path',
        'school_stamp_path',
        'school_signature_path',
        'address',
        'phone',
        'email',
        'website',
        'ministry_registration_no',
        'facebook_page',
        'extra_settings',
    ];

    protected $casts = [
        'extra_settings' => 'array',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
