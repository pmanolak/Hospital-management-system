<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'patient_id',
        'consultation_fee',
        'lab_test_fee',
        'medicine_fee',
        'total_amount',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
