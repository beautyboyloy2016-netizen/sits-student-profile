<?php

namespace App\Http\Requests\Fee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_date'        => 'required|date',
            'due_date'            => 'nullable|date',
            'status'              => 'required|in:unpaid,partial,paid,cancelled',
            'discount_amount'     => 'nullable|numeric|min:0',
            'items'               => 'nullable|array',
            'items.*.fee_type_id' => 'nullable|exists:fee_types,id',
            'items.*.description' => 'nullable|string',
            'items.*.qty'         => 'required_with:items|integer|min:1',
            'items.*.unit_price'  => 'required_with:items|numeric|min:0',
        ];
    }
}
