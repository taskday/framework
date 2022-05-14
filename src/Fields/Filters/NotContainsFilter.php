<?php

namespace Taskday\Fields\Filters;

use Illuminate\Database\Eloquent\Builder;

class NotContainsFilter extends AbstractFilter
{
    public function handle(Builder $query, string $handle, string $value)
    {
        $query->whereHas('fields', function ($q) use ($handle, $value) {
            $q->where('handle', $handle)->whereRaw("NOT FIND_IN_SET('{$value}', `value`)");
        });
    }
}

