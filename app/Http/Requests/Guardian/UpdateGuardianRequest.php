<?php

namespace App\Http\Requests\Guardian;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuardianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_kh'      => 'required|string|max:255',
            'name_en'      => 'nullable|string|max:255',
            'phone'        => 'nullable|string|max:50',
            'occupation'   => 'nullable|string|max:255',
            'province_id'  => 'nullable|exists:provinces,id',
            'district_id'  => 'nullable|exists:districts,id',
            'commune_id'   => 'nullable|exists:communes,id',
            'village_id'   => 'nullable|exists:villages,id',
            'street'       => 'nullable|string|max:255',
            'house_no'     => 'nullable|string|max:50',
            'note'         => 'nullable|string',
            'student_id'   => 'nullable|exists:students,id',
            'relationship' => 'nullable|string|max:50',
        ];
    }
}
