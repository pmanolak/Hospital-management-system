<?php 
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ExpiryDateFilter
{
    public static function apply(Builder $query, $value)
    {
        return $query->whereDate('expiry_date', '<=', $value);
    }
}
