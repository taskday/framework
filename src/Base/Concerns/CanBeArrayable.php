<?php

namespace Taskday\Base\Concerns;

use Illuminate\Support\Str;
use Taskday\Models\Field;
use ReflectionClass;
use ReflectionProperty;

trait CanBeArrayable
{
    /**
     * The cache of public property names, keyed by class.
     *
     * @var array
     */
    private static $propertyCache = [];

    /**
     * The cache of public method names, keyed by class.
     *
     * @var array
     */
    private static $methodCache = [];

    /**
     * The properties / methods that should not be exposed to the component.
     *
     * @var array
     */
    protected $except = [];

    /**
     * CustomField constructor.
     * @param Field $model
     */
    public function __construct(
        protected Field $model
    ) {}

    /**
     * Get the data that should be supplied to the view.
     *
     * @author Freek Van der Herten
     * @author Brent Roose
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->extractPublicProperties(), $this->extractPublicMethods());
    }

    /**
     * Extract the public properties for the component.
     *
     * @return array
     */
    private function extractPublicProperties()
    {
        $class = get_class($this);

        if (! isset(static::$propertyCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$propertyCache[$class] = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC))
                ->reject(function (ReflectionProperty $property) {
                    return $property->isStatic();
                })
                ->reject(function (ReflectionProperty $property) {
                    return $this->shouldIgnore($property->getName());
                })
                ->map(function (ReflectionProperty $property) {
                    return $property->getName();
                })->all();
        }

        $values = [];

        foreach (static::$propertyCache[$class] as $property) {
            $values[$property] = $this->{$property};
        }

        return $values;
    }

    /**
     * Extract the public methods for the component.
     *
     * @return array
     */
    private function extractPublicMethods()
    {
        $class = get_class($this);

        if (! isset(static::$methodCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$methodCache[$class] = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))
                ->reject(function (\ReflectionMethod $method) {
                    return $this->shouldIgnore($method->getName());
                })
                ->map(function (\ReflectionMethod $method) {
                    return $method->getName();
                });
        }

        $values = [];

        foreach (static::$methodCache[$class] as $method) {
            $values[$method] = call_user_func([$this, $method]);
        }

        return $values;
    }

    /**
     * Determine if the given property / method should be ignored.
     *
     * @param  string  $name
     * @return bool
     */
    private function shouldIgnore($name)
    {
        return Str::startsWith($name, '__') ||
            in_array($name, $this->ignoredMethods());
    }

    /**
     * Get the methods that should be ignored.
     *
     * @return array
     */
    private function ignoredMethods()
    {
        return array_merge([
            'toArray',
            'value',
        ], $this->except);
    }
}
