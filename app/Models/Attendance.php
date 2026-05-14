<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'branch_id',
        'attendable_type',
        'attendable_id',
        'class_id',
        'date',
        'status',
        'check_in_time',
        'check_out_time',
        'note',
        'recorded_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /** Polymorphic: resolves to Student or Staff */
    public function attendable()
    {
        $map = [
            'student' => Student::class,
            'staff'   => Staff::class,
        ];

        $related = $map[$this->attendable_type] ?? Student::class;
        return $this->belongsTo($related, 'attendable_id');
    }

    // ── Scopes ─────────────────────────────────────────────────

    public function scopeStudents($query)
    {
        return $query->where('attendable_type', 'student');
    }

    public function scopeStaff($query)
    {
        return $query->where('attendable_type', 'staff');
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }
}
