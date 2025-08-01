<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class NameFilter
{
    public static function apply(Builder $query, $value)
    {
        return $query->where('name', 'LIKE', "%{$value}%");
    }
}
