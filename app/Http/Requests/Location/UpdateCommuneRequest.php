<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommuneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'district_id' => 'required|exists:districts,id',
            'type'        => 'nullable|string|max:255',
            'code'        => 'nullable|string|max:255',
            'name_kh'     => 'required|string|max:255',
            'name_en'     => 'nullable|string|max:255',
        ];
    }
}
