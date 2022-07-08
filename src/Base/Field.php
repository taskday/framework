<?php


namespace Taskday\Base;

use Illuminate\Support\Facades\Event;
use Taskday\Base\Concerns\HasType;

abstract class Field
{
    use HasType;

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
    public function getSorter()
    {
        return null;
    }

    public function toArray()
    {
        return [];
    }
}
