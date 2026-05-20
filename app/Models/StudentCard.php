<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_cards';

    protected $fillable = ['student_id', 'template_id', 'card_no', 'issue_date', 'expire_date', 'qr_code', 'barcode', 'status', 'issued_by', 'printed_at', 'print_count', 'created_by', 'updated_by'];

    protected $casts = [
        'issue_date'  => 'date',
        'expire_date' => 'date',
        'printed_at'  => 'datetime',
        'print_count' => 'integer',
    ];

    public function student() { return $this->belongsTo(Student::class); }


    public function template() { return $this->belongsTo(PrintTemplate::class); }


    public function issuer() { return $this->belongsTo(User::class, 'issued_by'); }


    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

}
