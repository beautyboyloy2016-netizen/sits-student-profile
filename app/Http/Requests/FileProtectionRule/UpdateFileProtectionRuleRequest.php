<?php

namespace App\Http\Requests\FileProtectionRule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileProtectionRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'module'  => 'nullable|string|max:255',
            'role_id' => 'nullable|exists:roles,id',
        ];
    }
}
