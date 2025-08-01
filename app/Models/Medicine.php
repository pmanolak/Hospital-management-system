<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'expiry_date',
        'stock_threshold',
        'notes',
    ];
    protected $casts = [
        'expiry_date' => 'date',
    ];
}
