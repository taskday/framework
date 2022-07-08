<?php

namespace Taskday;

use Taskday\Base\Plugin;
use Taskday\Base\PluginCollection;
use Illuminate\Support\Collection;

class Taskday
{
    /**
     * An array of registered fields to their field.
     *
     * @var PluginCollection
     */
    protected PluginCollection $plugins;

    /**
     * Taskday Constructor.
     */
    public function __construct() {
        $this->plugins = new PluginCollection();
    }

    /**
     * Register field class with corresponding
     * key type string.
     *
     * @param string $key
     * @param string $class
     * @return void
     * @throws Exception
     */
    public function register(Plugin $plugin)
    {
        if (! is_subclass_of($plugin, Plugin::class) ) {
            throw new \Exception('plugin must be an instance of ' . Plugin::class);
        }

        if (! $plugin->handle) {
            throw new \Exception('plugin handle is required');
        }

        if ($this->plugins->has($plugin->handle)) {
            throw new \Exception('plugin already exists');
        }

        app()->singleton($plugin->handle, fn () => $plugin);

        foreach ($plugin->views() as $view) {
            app()->singleton($view::type(), fn () => $view);
        }

        $this->plugins[] = $plugin->handle;
    }


    /**
     * Get all registered fields.
     *
     * @return PluginCollection
     */
    public function plugins()
    {
        return collect($this->plugins)->map(function ($handle) {
            return app($handle);
        });
    }

    /**
     * Get all registered widgets.
     */
    public function widgets()
    {
        return $this->plugins()->flatMap->widgets()
            ->mapWithKeys(fn ($widget) => [$widget->handle => $widget->toArray()]);
    }

    /**
     * Get all the registered views.
     *
     */
    public function views(): Collection
    {
        return collect($this->plugins()->flatMap->views())->map(function ($view) {
            return app($view::type());
        });
    }

    /**
     * Return the registed fields that has the given type.
     *
     */
    public function getFieldByType(string $type): ?\Taskday\Base\Field
    {
        return collect($this->plugins()->flatMap->fields())
            ->filter(function(\Taskday\Base\Field $field) use ($type) {
                return $field::type() == $type;
            })
            ->first();
    }

    /**
     * Return the registed fields that has the given type.
     *
     */
    public function getViewByType(string $type): ?\Taskday\Base\View
    {
        return $this->views()
            ->filter(function(\Taskday\Base\View $field) use ($type) {
                return $field::type() == $type;
            })
            ->first();
    }
}
