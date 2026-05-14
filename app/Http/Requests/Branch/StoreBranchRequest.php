<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'       => 'required|string|max:20|unique:branches,code',
            'name_kh'    => 'required|string|max:255',
            'name_en'    => 'required|string|max:255',
            'address'    => 'nullable|string|max:500',
            'phone'      => 'nullable|string|max:30',
            'email'      => 'nullable|email|max:255',
            'logo_path'  => 'nullable|string|max:500',
            'is_main'    => 'boolean',
            'status'     => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'code'       => 'Branch Code',
            'name_kh'    => 'Khmer Name',
            'name_en'    => 'English Name',
            'address'    => 'Address',
            'phone'      => 'Phone',
            'email'      => 'Email',
            'logo_path'  => 'Logo',
            'is_main'    => 'Main Branch',
            'status'     => 'Status',
            'sort_order' => 'Sort Order',
        ];
    }
}
