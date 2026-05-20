<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FileProtectionRule extends Model
{
    use HasFactory;

    protected $table = 'file_protection_rules';

    protected $fillable = ['name', 'module', 'allow_download', 'allow_print', 'allow_export', 'watermark_enabled', 'role_id'];

    protected $casts = [
        'allow_download'    => 'boolean',
        'allow_print'       => 'boolean',
        'allow_export'      => 'boolean',
        'watermark_enabled' => 'boolean',
    ];

    public function role() { return $this->belongsTo(Role::class); }
}
