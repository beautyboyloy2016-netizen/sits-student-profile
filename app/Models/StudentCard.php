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

    public function student() { return $this->belongsTo(Student::class); }


    public function template() { return $this->belongsTo(PrintTemplate::class); }

}
