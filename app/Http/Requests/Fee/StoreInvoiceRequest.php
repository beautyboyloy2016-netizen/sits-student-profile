<?php

namespace App\Http\Requests\Fee;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id'          => 'required|exists:students,id',
            'invoice_date'        => 'required|date',
            'due_date'            => 'nullable|date',
            'items'               => 'required|array|min:1',
            'items.*.fee_type_id' => 'nullable|exists:fee_types,id',
            'items.*.description' => 'nullable|string',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ];
    }
}
