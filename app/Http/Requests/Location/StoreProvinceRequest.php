<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class StoreProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'    => 'nullable|string|max:255|unique:provinces',
            'name_kh' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ];
    }
}
