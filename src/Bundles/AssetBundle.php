<?php

namespace Taskday\Bundles;

abstract class AssetBundle
{
    abstract function scripts(): array;

    abstract function styles(): array;
}
