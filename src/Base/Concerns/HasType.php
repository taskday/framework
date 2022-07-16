<?php

namespace Taskday\Base\Concerns;

trait HasType
{
    /**
     * Handle the custom field.
     *
     * @return string
     */
    public static function type(): string
    {
        $name = (new \ReflectionClass(static::class))->getShortName();

        return collect(str($name)->snake()->explode('_'))->slice(0, -1)->join('-');
    }
}
