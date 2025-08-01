<?php
namespace App\Filters;
use Illuminate\Database\Eloquent\Builder;

class DateFilter
{
    public function apply($query, $value)
    {
        return $query->whereDate('created_at', $value);
    }
}





