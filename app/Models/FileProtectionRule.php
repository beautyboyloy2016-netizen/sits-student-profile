<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FileProtectionRule extends Model
{
    use HasFactory;

    protected $table = 'file_protection_rules';

    protected $fillable = ['name', 'module', 'allow_download', 'allow_print', 'allow_export', 'watermark_enabled', 'role_id'];

    public function role() { return $this->belongsTo(Role::class); }
}
