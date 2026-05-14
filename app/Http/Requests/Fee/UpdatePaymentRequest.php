<?php

namespace App\Http\Requests\Fee;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id'     => 'nullable|exists:student_invoices,id',
            'payment_date'   => 'required|date',
            'amount'         => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank,aba,wing,other',
            'note'           => 'nullable|string',
        ];
    }
}
