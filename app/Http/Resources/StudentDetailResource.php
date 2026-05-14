<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'student_code'   => $this->student_code,
            'khmer_name'     => $this->khmer_name,
            'latin_name'     => $this->latin_name,
            'gender'         => $this->whenLoaded('gender', fn() => ['id' => $this->gender?->id, 'name' => $this->gender?->name]),
            'date_of_birth'  => $this->date_of_birth,
            'phone'          => $this->phone,
            'email'          => $this->email,
            'photo_path'     => $this->photo_path,
            'status'         => $this->status,
            'note'           => $this->note,
            'birth_place'    => $this->whenLoaded('birthPlace', fn() => $this->formatAddress($this->birthPlace)),
            'current_address'=> $this->whenLoaded('currentAddress', fn() => $this->formatAddress($this->currentAddress)),
            'guardians'      => GuardianResource::collection($this->whenLoaded('guardians')),
            'enrollments'    => $this->whenLoaded('enrollments', fn() => $this->enrollments->map(fn($e) => [
                'id'            => $e->id,
                'class_code'    => $e->class?->class_code,
                'course'        => $e->class?->course?->name,
                'academic_year' => $e->academicYear?->name,
                'shift'         => $e->shift?->name,
                'status'        => $e->status,
                'enroll_date'   => $e->enroll_date,
            ])),
            'files'         => $this->whenLoaded('files', fn() => $this->files->map(fn($f) => [
                'id'        => $f->id,
                'file_type' => $f->file_type,
                'file_path' => $f->file_path,
            ])),
            'created_at'    => $this->created_at?->toDateTimeString(),
            'updated_at'    => $this->updated_at?->toDateTimeString(),
        ];
    }

    private function formatAddress($address): ?array
    {
        if (!$address) return null;
        return [
            'province' => $address->province?->name_kh,
            'district' => $address->district?->name_kh,
            'commune'  => $address->commune?->name_kh,
            'village'  => $address->village?->name_kh,
            'street'   => $address->street,
            'house_no' => $address->house_no,
        ];
    }
}
