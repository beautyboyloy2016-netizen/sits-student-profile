<?php

namespace App\Http\Requests\StudentCertificate;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'certificate_type' => 'required|in:appreciation,achievement,participation,completion,excellent_student,other',
            'template_id'      => 'nullable|exists:print_templates,id',
            'title'            => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'issue_date'       => 'nullable|date',
        ];
    }
}
