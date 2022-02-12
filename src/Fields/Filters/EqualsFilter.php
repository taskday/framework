<?php

namespace Taskday\Fields\Filters;

use Illuminate\Database\Eloquent\Builder;

class EqualsFilter extends AbstractFilter
{
    public function handle(Builder $query, string $class, string $value)
    {
        $query->whereHas('fields', function ($q) use ($class, $value) {
            $q->where('type', $class::type())->where('value', $value);
        });
    }
}
