<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ExportLog extends Model
{
    use HasFactory;

    protected $table = 'export_logs';

    protected $fillable = ['export_type', 'file_path', 'filter_data', 'exported_by', 'exported_at'];

    protected $casts = [
        'filter_data' => 'array',
        'exported_at' => 'datetime',
    ];

    public function exporter() { return $this->belongsTo(User::class, 'exported_by'); }
}
