<?php

namespace App\Http\Requests\StudentRoomAssignment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRoomAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id'        => 'required|exists:rooms,id',
            'check_in_date'  => 'nullable|date',
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'status'         => 'required|in:active,checked_out,cancelled',
            'note'           => 'nullable|string',
        ];
    }
}
