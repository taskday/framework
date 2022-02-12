<?php

namespace Taskday\Fields\Filters;

use Illuminate\Database\Eloquent\Builder;

class NotContainsFilter extends AbstractFilter
{
    public function handle(Builder $query, string $class, string $value)
    {
        $query->whereHas('fields', function ($q) use ($class, $value) {
            $q->where('type', $class::type())->whereRaw("NOT FIND_IN_SET('{$value}', `value`)");
        });
    }
}

