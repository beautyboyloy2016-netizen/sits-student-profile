<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PrintLog extends Model
{
    use HasFactory;

    protected $table = 'print_logs';

    protected $fillable = ['printable_type', 'printable_id', 'template_id', 'printed_by', 'printed_at', 'printer_name', 'copies', 'ip_address', 'user_agent'];

    protected $casts = [
        'printed_at' => 'datetime',
        'copies'     => 'integer',
    ];

    public function template() { return $this->belongsTo(PrintTemplate::class, 'template_id'); }
    public function printer() { return $this->belongsTo(User::class, 'printed_by'); }
}
