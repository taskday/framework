<?php


namespace Taskday\Base;

use Taskday\Support\CanBeArrayable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Event;
use ReflectionClass;

abstract class Field
{
    /**
     * Handle the custom field.
     *
     * @return string
     */
    public static function type(): string
    {
        return strtolower(str_replace('Field', '', (new ReflectionClass(static::class))->getShortName()));
    }

    /**
     * Handle the custom field.
     *
     * @param string $event
     * @param string $class
     * @return void
     */
    public function listen(string $event, string $class): void
    {
        Event::listen($event, [$class, 'handle']);
    }

    /**
     * Boostrap the component.
     */
    public function boot()
    {
        //
    }
}
