<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistrictRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'province_id' => 'required|exists:provinces,id',
            'type'        => 'nullable|string|max:255',
            'code'        => 'nullable|string|max:255',
            'name_kh'     => 'required|string|max:255',
            'name_en'     => 'nullable|string|max:255',
        ];
    }
}
