<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BOQEntry extends Model
{
    protected $fillable = ['project_id', 'item'];
}
