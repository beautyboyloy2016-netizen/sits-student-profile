<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role')?->id ?? $this->route('role');

        return [
            'name'             => 'required|string|max:255|unique:roles,name,' . $roleId,
            'display_name'     => 'required|string|max:255',
            'description'      => 'nullable|string',
            'permission_ids'   => 'nullable|array',
            'permission_ids.*' => 'exists:permissions,id',
        ];
    }
}
