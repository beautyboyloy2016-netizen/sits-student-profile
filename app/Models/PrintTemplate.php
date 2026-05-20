<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'print_templates';

    protected $fillable = [
        'branch_id',
        'name',
        'template_type',
        'paper_size',
        'orientation',
        'html_template',
        'css_template',
        'settings',
        'is_default',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'settings'   => 'array',
        'is_default' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function cards()
    {
        return $this->hasMany(StudentCard::class, 'template_id');
    }

    public function certificates()
    {
        return $this->hasMany(StudentCertificate::class, 'template_id');
    }

    public function diplomas()
    {
        return $this->hasMany(StudentDiploma::class, 'template_id');
    }
}
