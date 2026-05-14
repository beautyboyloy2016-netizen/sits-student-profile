<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'print_templates';

    protected $fillable = ['name', 'template_type', 'paper_size', 'orientation', 'html_template', 'css_template', 'settings', 'is_default', 'status', 'created_by', 'updated_by'];
}
