<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'code', 'name_kh', 'name_en', 'address',
        'phone', 'email', 'logo_path', 'is_main', 'status', 'sort_order',
    ];

    protected $casts = [
        'is_main'    => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_user');
    }

    public function setting()
    {
        return $this->hasOne(BranchSetting::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function feeTypes()
    {
        return $this->hasMany(FeeType::class);
    }

    public function invoices()
    {
        return $this->hasMany(StudentInvoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function printTemplates()
    {
        return $this->hasMany(PrintTemplate::class);
    }
}
