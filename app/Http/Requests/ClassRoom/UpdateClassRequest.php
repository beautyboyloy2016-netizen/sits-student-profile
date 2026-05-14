<?php

namespace App\Http\Requests\ClassRoom;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $classId = $this->route('class')?->id ?? $this->route('class');

        return [
            'class_code'       => 'required|string|unique:classes,class_code,' . $classId,
            'course_id'        => 'required|exists:courses,id',
            'level_id'         => 'nullable|exists:levels,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'shift_id'         => 'nullable|exists:shifts,id',
            'teacher_id'       => 'nullable|exists:staff,id',
            'room_id'          => 'nullable|exists:rooms,id',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
            'status'           => 'required|in:active,completed,cancelled',
        ];
    }
}
