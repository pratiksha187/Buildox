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
    ];

    protected $casts = [
        'construction_type' => 'array',
        'plot_ready' => 'boolean',
    ];

}
