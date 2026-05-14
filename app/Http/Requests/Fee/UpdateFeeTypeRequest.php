<?php

namespace App\Http\Requests\Fee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }
}
