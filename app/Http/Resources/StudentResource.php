<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'student_code' => $this->student_code,
            'khmer_name'   => $this->khmer_name,
            'latin_name'   => $this->latin_name,
            'gender'       => $this->whenLoaded('gender', fn() => $this->gender?->name),
            'status'       => $this->status,
            'phone'        => $this->phone,
            'email'        => $this->email,
            'photo_path'   => $this->photo_path,
            'created_at'   => $this->created_at?->toDateString(),
        ];
    }
}
