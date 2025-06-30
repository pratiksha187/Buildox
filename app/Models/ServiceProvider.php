<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Notifications\Notifiable;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $table = 'service_provider';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'business_name',
        'gst_number',
        'location',
        'password',
    ];

   
}
