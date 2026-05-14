<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guardians';

    protected $fillable = ['name_kh', 'name_en', 'phone', 'occupation', 'address_id', 'note'];

    public function address() { return $this->belongsTo(Address::class); }


    public function students() { return $this->belongsToMany(Student::class, 'student_guardians')->withPivot('relationship', 'is_primary'); }

}
