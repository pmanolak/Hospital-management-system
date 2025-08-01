<?php

namespace App\Helpers;

use Illuminate\Pipeline\Pipeline;

class FilterPipeline
{
    public static function apply($query, $filters, $map)
    {
        $pipes = [];

        foreach ($filters as $key => $value) {
            if (isset($map[$key])) {
                $filterClass = $map[$key];
                $pipes[] = function ($query) use ($filterClass, $value) {
                    $filter = new $filterClass();
                    return $filter->apply($query, $value);
                };
            }
        }

        return app(Pipeline::class)
            ->send($query)
            ->through($pipes)
            ->thenReturn();
    }
}
