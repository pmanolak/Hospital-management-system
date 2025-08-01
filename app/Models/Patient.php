<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable; 

class Patient extends Model
{
    use SoftDeletes, Notifiable;  

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'gender',
        'dob',
        'phone',
        'address',
    ];
}
