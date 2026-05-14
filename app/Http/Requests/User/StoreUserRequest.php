<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255|unique:users',
            'phone'      => 'nullable|string|max:50|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'status'     => 'required|in:active,inactive,blocked',
            'role_ids'   => 'nullable|array',
            'role_ids.*' => 'exists:roles,id',
        ];
    }
}
