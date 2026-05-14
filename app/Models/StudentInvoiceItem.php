<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentInvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'student_invoice_items';

    protected $fillable = ['invoice_id', 'fee_type_id', 'description', 'qty', 'unit_price', 'total'];

    public function invoice() { return $this->belongsTo(StudentInvoice::class); }


    public function feeType() { return $this->belongsTo(FeeType::class); }

}
