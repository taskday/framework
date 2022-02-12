<?php

namespace Taskday\Base;

use Taskday\Bundles\AssetBundle;

abstract class Plugin
{
    public string $handle;

    public string $description;

    function bundle(): ?AssetBundle
    {
        return null;
    }

    /** @return CustomField[] */
    public function fields(): array
    {
        return [];
    }

    /** @return CustomFilter[] */
    public function filters(): array
    {
        return [];
    }

    /** @return CustomActions[] */
    public function actions(): array
    {
        return [];
    }

    /** @return CustomView[] */
    public function views(): array
    {
        return [];
    }

    public function widgets(): array
    {
        return [];
    }
}
