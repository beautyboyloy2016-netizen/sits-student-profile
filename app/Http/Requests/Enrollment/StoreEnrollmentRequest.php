<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id'       => 'required|exists:students,id',
            'class_id'         => 'required|exists:classes,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'shift_id'         => 'nullable|exists:shifts,id',
            'enroll_date'      => 'nullable|date',
            'study_time_label' => 'nullable|string|max:100',
            'status'           => 'required|in:studying,completed,dropped,transferred',
            'note'             => 'nullable|string',
        ];
    }
}
