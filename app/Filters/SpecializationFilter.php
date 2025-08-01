<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SpecializationFilter
{
    public static function apply(Builder $query, $value)
    {
        return $query->where('specialization', 'LIKE', "%{$value}%");
    }
}

