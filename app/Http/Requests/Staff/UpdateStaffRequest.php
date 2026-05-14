<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $staffId = $this->route('staff')?->id ?? $this->route('staff');

        return [
            'staff_code' => 'required|string|unique:staff,staff_code,' . $staffId,
            'name_kh'    => 'required|string|max:255',
            'name_en'    => 'nullable|string|max:255',
            'gender_id'  => 'nullable|exists:genders,id',
            'phone'      => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255|unique:staff,email,' . $staffId,
            'position'   => 'nullable|string|max:255',
            'status'     => 'required|in:active,inactive',
        ];
    }
}
