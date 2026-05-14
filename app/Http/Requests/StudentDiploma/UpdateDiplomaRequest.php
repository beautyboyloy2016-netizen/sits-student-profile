<?php

namespace App\Http\Requests\StudentDiploma;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiplomaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'template_id'     => 'nullable|exists:print_templates,id',
            'graduation_date' => 'nullable|date',
            'issue_date'      => 'nullable|date',
            'grade'           => 'nullable|string|max:50',
            'gpa'             => 'nullable|numeric|min:0|max:4',
            'description'     => 'nullable|string',
            'status'          => 'required|in:draft,approved,printed,cancelled',
        ];
    }
}
