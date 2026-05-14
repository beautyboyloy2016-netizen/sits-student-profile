<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';

    protected $fillable = ['branch_id', 'student_code', 'khmer_name', 'latin_name', 'gender_id', 'date_of_birth', 'birth_place_id', 'current_address_id', 'phone', 'email', 'photo_path', 'status', 'note', 'created_by', 'updated_by'];

    public function branch() { return $this->belongsTo(Branch::class); }

    public function gender() { return $this->belongsTo(Gender::class); }


    public function birthPlace() { return $this->belongsTo(Address::class, 'birth_place_id'); }


    public function currentAddress() { return $this->belongsTo(Address::class, 'current_address_id'); }


    public function creator() { return $this->belongsTo(User::class, 'created_by'); }


    public function updater() { return $this->belongsTo(User::class, 'updated_by'); }


    public function guardians() { return $this->belongsToMany(Guardian::class, 'student_guardians')->withPivot('relationship', 'is_primary'); }


    public function enrollments() { return $this->hasMany(Enrollment::class); }


    public function roomAssignments() { return $this->hasMany(StudentRoomAssignment::class); }


    public function files() { return $this->hasMany(StudentFile::class); }


    public function cards() { return $this->hasMany(StudentCard::class); }


    public function certificates() { return $this->hasMany(StudentCertificate::class); }


    public function diplomas() { return $this->hasMany(StudentDiploma::class); }


    public function invoices() { return $this->hasMany(StudentInvoice::class); }


    public function payments() { return $this->hasMany(Payment::class); }


    public function updateRequests() { return $this->hasMany(StudentUpdateRequest::class); }

}
