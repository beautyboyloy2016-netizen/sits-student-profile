<?php

namespace App\Http\Requests\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255|unique:academic_years',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'status'     => 'required|in:active,inactive,closed',
        ];
    }
}
