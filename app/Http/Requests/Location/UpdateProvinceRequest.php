<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('province')?->id ?? $this->route('province');

        return [
            'code'    => 'nullable|string|max:255|unique:provinces,code,' . $id,
            'name_kh' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ];
    }
}
