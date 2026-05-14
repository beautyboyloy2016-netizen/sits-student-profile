<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_invoices';

    protected $fillable = ['branch_id', 'invoice_no', 'student_id', 'invoice_date', 'due_date', 'total_amount', 'discount_amount', 'paid_amount', 'balance', 'status', 'created_by', 'updated_by'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function student() { return $this->belongsTo(Student::class); }


    public function items() { return $this->hasMany(StudentInvoiceItem::class, 'invoice_id'); }


    public function payments() { return $this->hasMany(Payment::class, 'invoice_id'); }

}
