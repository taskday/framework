<?php

namespace Taskday\Base;

use Taskday\Bundles\AssetBundle;

abstract class Plugin
{
    public string $handle;

    public string $description;

    public function bundle(): ?AssetBundle
    {
        return null;
    }

    /** @return Field[] */
    public function fields(): array
    {
        return [];
    }

    /** @return Filter[] */
    public function filters(): array
    {
        return [];
    }

    /** @return Action[] */
    public function actions(): array
    {
        return [];
    }

    /** @return View[] */
    public function views(): array
    {
        return [];
    }

    public function widgets(): array
    {
        return [];
    }
}
