<?php
namespace App\Filters;
use Illuminate\Database\Eloquent\Builder;

class AppointmentIdFilter
{
    public function apply($query, $value)
    {
        return $query->where('appointment_id', $value);
    }
}
