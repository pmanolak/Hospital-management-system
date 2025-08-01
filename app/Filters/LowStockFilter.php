<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class LowStockFilter
{
    public static function apply(Builder $query, $value)
    {
        return $query->whereColumn('quantity', '<=', 'stock_threshold');
    }
}
