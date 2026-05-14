<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_files';

    protected $fillable = ['student_id', 'file_type', 'file_path', 'original_name', 'mime_type', 'size', 'is_primary', 'uploaded_by'];

    public function student() { return $this->belongsTo(Student::class); }


    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }

}
