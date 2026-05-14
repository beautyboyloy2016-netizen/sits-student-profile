<?php

namespace App\Http\Requests\Shift;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'start_time' => 'nullable',
            'end_time'   => 'nullable|after_or_equal:start_time',
            'status'     => 'required|in:active,inactive',
        ];
    }
}
