<?php

namespace App\Http\Requests\StudentRoomAssignment;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRoomAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id'       => 'required|exists:rooms,id',
            'check_in_date' => 'nullable|date',
            'note'          => 'nullable|string',
        ];
    }
}
