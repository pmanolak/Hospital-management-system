<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AvailabilityFilter
{
    public static function apply(Builder $query, $value)
    {
        return $query->where('availability', 'LIKE', "%{$value}%");
    }
}
