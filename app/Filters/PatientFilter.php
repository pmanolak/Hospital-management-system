<?php

namespace App\Filters;

class PatientFilter
{
    public static function apply($query, $value)
    {
        return $query->where('patient_id', $value);
    }
}


