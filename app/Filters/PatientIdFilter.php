<?php
namespace App\Filters;

class PatientIdFilter
{
    public static function apply($query, $value)
    {
        return $query->where('patient_id', $value);
    }
}
