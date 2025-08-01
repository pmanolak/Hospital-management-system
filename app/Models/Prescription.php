<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'appointment_id',
        'medicines',
        'instructions',
    ];

    public function appointment()
    {
        return $this->belongsTo(\App\Models\Appointment::class);
    }
}
