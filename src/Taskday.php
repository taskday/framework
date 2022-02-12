<?php

namespace Taskday;

use Taskday\Base\Plugin;
use Taskday\Base\PluginCollection;

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

        $this->plugins[$plugin->handle] = $plugin;
    }


    /**
     * Get all registered fields.
     *
     * @return PluginCollection
     */
    public function plugins()
    {
        return $this->plugins;
    }

    /**
     * Get all registered widgets.
     */
    public function widgets()
    {
        return $this->plugins
            ->flatMap(fn ($plugin) => $plugin->widgets())
            ->mapWithKeys(fn ($widget) => [$widget->handle => $widget->toArray()]);
    }

    // /**
    //  * Register action class with corresponding
    //  * key type string.
    //  *
    //  * @param string $key
    //  * @param string $class
    //  * @return void
    //  * @throws Exception
    //  */
    // public function registerAction(string $key, string $class)
    // {
    //     if (array_key_exists($key, $this->actions)) {
    //         throw new \Exception('Key already in used by another action');
    //     }

    //     $this->actions[$key] = $class;
    // }

    // /**
    //  * Register action class with corresponding
    //  * key type string.
    //  *
    //  * @param string $key
    //  * @param string $class
    //  * @return void
    //  * @throws Exception
    //  */
    // public function registerViewType(string $key, string $class)
    // {
    //     if (array_key_exists($key, $this->actions)) {
    //         throw new \Exception('Key already in used by another action');
    //     }

    //     $this->views[$key] = $class;
    // }

    // public function registerAssetBundle($bundle)
    // {
    //     $this->bundles[] = $bundle;
    // }

    // /**
    //  * Get styles for all registered bundles.
    //  * @return mixed
    //  */
    // public function getStyles(): Collection
    // {
    //     return collect($this->bundles)->flatMap->styles()->map(function($path) {
    //         return Str::afterLast(realpath($path), base_path());
    //     });
    // }

    // /**
    //  * Get scripts for all registerd bundles.
    //  *
    //  * @return mixed
    //  */
    // public function getScripts(): Collection
    // {
    //     return collect($this->bundles)->flatMap->scripts()->map(function($path) {
    //         return Str::afterLast(realpath($path), base_path());
    //     });
    // }

    // /**
    //  * Return the registed fields on the core.
    //  *
    //  * @return Collection
    //  */
    // public function getFields(): Collection
    // {
    //     return collect($this->fields);
    // }

    // /**
    //  * Return the registed fields on the core.
    //  *
    //  * @return string|null
    //  */
    // public function getField(string $type): ?string
    // {
    //     return $this->fields[$type] ?? null;
    // }
}
