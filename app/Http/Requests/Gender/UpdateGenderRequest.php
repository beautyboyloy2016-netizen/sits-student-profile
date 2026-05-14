<?php

namespace App\Http\Requests\Gender;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_kh'    => 'required|string|max:255',
            'name_en'    => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
