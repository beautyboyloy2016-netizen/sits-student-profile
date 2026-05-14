<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'address_id' => 'nullable|exists:addresses,id',
            'status'     => 'required|in:active,inactive',
        ];
    }
}
