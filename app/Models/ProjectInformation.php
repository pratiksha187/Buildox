<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInformation extends Model
{
    protected $table = 'project_information';

    protected $fillable = [
    'full_name',
    'phone_number',
    'email',
    'role',
    'construction_type',
    'plot_ready',
    'project_type',
    'sub_categories',
    'profile_image'
    ];

    protected $casts = [
    'sub_categories' => 'array',
    'plot_ready' => 'boolean',
];



}
