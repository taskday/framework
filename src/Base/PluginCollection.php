<?php

namespace Taskday\Base;

use \Illuminate\Support\Collection;
use Taskday\Base\Plugin;

class PluginCollection extends Collection
{
    /**
     * The items contained in the collection.
     *
     * @var Plugin[]
     */
    protected $items = [];
}
