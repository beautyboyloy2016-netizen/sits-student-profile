<?php

namespace App\Http\Requests\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademicYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('academic_year')?->id ?? $this->route('academic_year');

        return [
            'name'       => 'required|string|max:255|unique:academic_years,name,' . $id,
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'boolean',
            'status'     => 'required|in:active,inactive,closed',
        ];
    }
}
