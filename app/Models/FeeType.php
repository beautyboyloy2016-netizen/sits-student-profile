<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fee_types';

    protected $fillable = ['branch_id', 'name', 'amount', 'status'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function invoiceItems() { return $this->hasMany(StudentInvoiceItem::class); }

}
