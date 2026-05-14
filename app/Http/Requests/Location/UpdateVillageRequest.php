<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVillageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commune_id' => 'required|exists:communes,id',
            'type'       => 'nullable|string|max:255',
            'code'       => 'nullable|string|max:255',
            'name_kh'    => 'required|string|max:255',
            'name_en'    => 'nullable|string|max:255',
        ];
    }
}
