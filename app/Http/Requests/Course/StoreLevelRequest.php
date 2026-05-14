<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id'  => 'required|exists:courses,id',
            'name'       => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
