<?php

namespace App\Http\Requests\StudentCard;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id' => 'nullable|exists:print_templates,id',
            'issue_date'  => 'nullable|date',
            'expire_date' => 'nullable|date|after_or_equal:issue_date',
        ];
    }
}
