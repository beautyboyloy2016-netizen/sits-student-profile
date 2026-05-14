<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = ['branch_id', 'user_id', 'action', 'table_name', 'record_id', 'old_values', 'new_values', 'ip_address', 'user_agent'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function user() { return $this->belongsTo(User::class); }

}
