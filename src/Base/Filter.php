<?php

namespace Taskday\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Taskday\Base\Concerns\HasType;
use Illuminate\Contracts\Support\Arrayable;

abstract class Filter implements Scope, Arrayable
{
    use HasType;

    protected $name;

    /**
     * Configure the filter
     */
    public function boot(): void
    {
        //
    }

    /**
     * Return the possible columns to use with this filter.
     *
     * @return Array<Operator>
     */
    abstract public function columns(): array;

    /**
     * Return the possible operators to use with this filter.
     *
     * @return Array<Operator>
     */
    abstract public function operators(): array;


    /**
     * Return an array of this filter.
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name ?? static::type(),
            'type' => static::type(),
            'columns' => $this->columns(),
            'operators' => $this->operators(),
            'options' => []
        ];
    }
}
