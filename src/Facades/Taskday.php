<?php

namespace Taskday\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self plugin(AbstractPlugin $plugin)
 * @method static Collection getRegisteredFields()
 * @method static string getRegisteredField(string $type)
 * @method static self regsiterField(CustomField $type, string $type)
 */
class Taskday extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'taskday';
    }
}
