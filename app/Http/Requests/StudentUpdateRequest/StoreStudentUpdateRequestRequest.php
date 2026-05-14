<?php

namespace App\Http\Requests\StudentUpdateRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentUpdateRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'field_name' => 'required|string|max:255',
            'old_value'  => 'nullable|string',
            'new_value'  => 'nullable|string',
            'reason'     => 'nullable|string',
        ];
    }
}
