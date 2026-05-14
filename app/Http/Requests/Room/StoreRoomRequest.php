<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id'   => 'required|exists:buildings,id',
            'room_no'       => 'required|string|max:50',
            'room_type'     => 'required|in:single,double,shared,classroom',
            'capacity'      => 'required|integer|min:0',
            'monthly_price' => 'required|numeric|min:0',
            'status'        => 'required|in:available,full,maintenance,inactive',
        ];
    }
}
