<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_code'          => 'required|string|unique:students',
            'khmer_name'            => 'required|string|max:255',
            'latin_name'            => 'nullable|string|max:255',
            'gender_id'             => 'nullable|exists:genders,id',
            'date_of_birth'         => 'nullable|date',
            'phone'                 => 'nullable|string|max:50',
            'email'                 => 'nullable|email|max:255',
            'photo'                 => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,heic,heif|max:10240',
            'status'                => 'required|in:active,inactive,graduated,suspended,dropped',
            'note'                  => 'nullable|string',

            'birth_province_id'     => 'nullable|exists:provinces,id',
            'birth_district_id'     => 'nullable|exists:districts,id',
            'birth_commune_id'      => 'nullable|exists:communes,id',
            'birth_village_id'      => 'nullable|exists:villages,id',
            'birth_street'          => 'nullable|string|max:255',
            'birth_house_no'        => 'nullable|string|max:50',

            'current_province_id'   => 'nullable|exists:provinces,id',
            'current_district_id'   => 'nullable|exists:districts,id',
            'current_commune_id'    => 'nullable|exists:communes,id',
            'current_village_id'    => 'nullable|exists:villages,id',
            'current_street'        => 'nullable|string|max:255',
            'current_house_no'      => 'nullable|string|max:50',

            'guardian_name_kh'      => 'nullable|string|max:255',
            'guardian_name_en'      => 'nullable|string|max:255',
            'guardian_phone'        => 'nullable|string|max:50',
            'guardian_occupation'   => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:50',

            'course_id'             => 'nullable|exists:courses,id',
            'class_id'              => 'nullable|exists:classes,id',
            'academic_year_id'      => 'nullable|exists:academic_years,id',
            'shift_id'              => 'nullable|exists:shifts,id',
            'enroll_date'           => 'nullable|date',
        ];
    }
}
