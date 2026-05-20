<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    use HasFactory;

    protected $table = 'student_guardians';

    protected $fillable = ['student_id', 'guardian_id', 'relationship', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function student() { return $this->belongsTo(Student::class); }


    public function guardian() { return $this->belongsTo(Guardian::class); }

}
