<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GenderFilter
{
    public static function apply(Builder $query, $value)
    {
        return $query->where('gender', $value);
    }
}
