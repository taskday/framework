<?php

namespace Taskday\Fields\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    abstract function handle(Builder $query, string $class, string $value);
}
