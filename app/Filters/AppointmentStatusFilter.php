<?php

namespace App\Filters;

class AppointmentStatusFilter
{
    public static function apply($query, $value)
    {
        return $query->where('status', $value);
    }
}

