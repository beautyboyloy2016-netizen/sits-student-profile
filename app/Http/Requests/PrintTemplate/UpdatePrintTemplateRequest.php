<?php

namespace App\Http\Requests\PrintTemplate;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrintTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'template_type' => 'required|in:student_card,certificate,diploma',
            'paper_size'    => 'nullable|string|max:50',
            'orientation'   => 'required|in:portrait,landscape',
            'html_template' => 'nullable|string',
            'css_template'  => 'nullable|string',
            'status'        => 'required|in:active,inactive',
        ];
    }
}
