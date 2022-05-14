<?php

namespace Taskday\Fields\Filters;

use Illuminate\Database\Eloquent\Builder;

class ContainsFilter extends AbstractFilter
{
    public function handle(Builder $query, string $handle, string $value)
    {
        $query->whereHas('fields', function ($q) use ($handle, $value) {
            $q->where('handle', $handle)->whereRaw("FIND_IN_SET('{$value}', `value`)");
        });
    }
}
