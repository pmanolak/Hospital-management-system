<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class StatusFilter
{
    public static function apply(Builder $query, $value)
    {
        if ($value === 'inactive') {
            return $query->onlyTrashed();
        }
        return $query;  
    }
}
