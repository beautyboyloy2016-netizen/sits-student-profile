<?php

namespace App\Http\Requests\StudentFile;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_type' => 'required|in:photo,birth_certificate,id_card,certificate,diploma,document,other',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx|max:10240',
            'is_primary' => 'nullable|boolean',
        ];
    }
}
