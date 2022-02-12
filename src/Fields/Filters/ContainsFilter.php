<?php

namespace Taskday\Fields\Filters;

use Illuminate\Database\Eloquent\Builder;

class ContainsFilter extends AbstractFilter
{
    public function handle(Builder $query, string $class, string $value)
    {
        $query->whereHas('fields', function ($q) use ($class, $value) {
            $q->where('type', $class::type())->whereRaw("FIND_IN_SET('{$value}', `value`)");
        });
    }
}
