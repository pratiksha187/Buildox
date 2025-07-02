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
    'password',
    'login_id',
    'role',
    'construction_type',
    'plot_ready',
    'project_type',
    'sub_categories',
    'profile_image',
    'land_location',
    'land_type',
    'survey_no',
    'area',
    'area_unit',
    'has_arch_drawing',
    'has_structural_drawing',
    'boqCheckbox',
    'boqFile',
    ];

    protected $casts = [
    'sub_categories' => 'array',
    'plot_ready' => 'boolean', 
];



}
