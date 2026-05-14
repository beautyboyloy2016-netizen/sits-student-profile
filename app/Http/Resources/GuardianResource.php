<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardianResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name_kh'      => $this->name_kh,
            'name_en'      => $this->name_en,
            'phone'        => $this->phone,
            'occupation'   => $this->occupation,
            'relationship' => $this->whenPivotLoaded('student_guardians', fn() => $this->pivot?->relationship),
        ];
    }
}
