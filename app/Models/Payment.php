<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $fillable = ['branch_id', 'payment_no', 'invoice_id', 'student_id', 'payment_date', 'amount', 'payment_method', 'received_by', 'note'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function student() { return $this->belongsTo(Student::class); }


    public function invoice() { return $this->belongsTo(StudentInvoice::class); }


    public function receiver() { return $this->belongsTo(User::class, 'received_by'); }

}
