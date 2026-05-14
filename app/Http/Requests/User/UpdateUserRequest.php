<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255|unique:users,email,' . $userId,
            'phone'      => 'nullable|string|max:50|unique:users,phone,' . $userId,
            'password'   => 'nullable|string|min:8|confirmed',
            'status'     => 'required|in:active,inactive,blocked',
            'role_ids'   => 'nullable|array',
            'role_ids.*' => 'exists:roles,id',
        ];
    }
}
