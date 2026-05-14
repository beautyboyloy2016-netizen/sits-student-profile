<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FileAccessLog extends Model
{
    use HasFactory;

    protected $table = 'file_access_logs';

    protected $fillable = ['user_id', 'student_file_id', 'action', 'ip_address', 'user_agent'];

    public function user() { return $this->belongsTo(User::class); }
    public function studentFile() { return $this->belongsTo(StudentFile::class); }
}
