<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UsersLogin extends Model
{
    use Notifiable;
    protected $table = 'userslogin';
    protected $fillable = [
        'name', 'email', 'mobile', 'business_name', 'gst_number', 'location', 'password','role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
