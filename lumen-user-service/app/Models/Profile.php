<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['auth_id','name','email'];
}
// The Profile model represents the user profile in the application.