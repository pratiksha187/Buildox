<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProjectInquiry extends Model
{
    use HasFactory;
    protected $table = 'project_inquiries';
    
    protected $fillable = [
        'name',
        'phone',
        'email',
        'project_type',
        'project_brief',
        'preferred_day',
        'preferred_time',
    ];
    
}
