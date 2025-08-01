<?php

namespace App\Filters;

class DoctorFilter
{
    public static function apply($query, $value)
    {
        return $query->where('doctor_id', $value);
    }
}
