<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ReportLog extends Model
{
    use HasFactory;

    protected $table = 'report_logs';

    protected $fillable = ['branch_id', 'report_type', 'report_title', 'filters', 'file_path', 'export_format', 'generated_by', 'generated_at'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function generator() { return $this->belongsTo(User::class, 'generated_by'); }
}
