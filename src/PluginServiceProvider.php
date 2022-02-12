<?php

declare(strict_types=1);

namespace Taskday;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Taskday\Base\Concerns\CanPretendToBeAFile;
use Taskday\Bundles\AssetBundle;
use Taskday\Facades\Taskday;

abstract class PluginServiceProvider extends ServiceProvider
{
    use CanPretendToBeAFile;

    public function registerAssetBundle(AssetBundle $bundle)
    {
        Taskday::registerAssetBundle($bundle);

        collect($bundle->scripts())->each(function($path) {
            $route = Str::afterLast(realpath($path), base_path());

            Route::get($route, function() use ($path) {
                return $this->pretendResponseIsFile($path, 'application/javascript');
            });
        });

        collect($bundle->styles())->each(function($path) {
            $route = Str::afterLast(realpath($path), base_path());

            Route::get($route, function() use ($path) {
                return $this->pretendResponseIsFile($path, 'text/css');
            });
        });
    }

    protected function registerFieldType(string $class, string $type)
    {
        Taskday::registerFieldType($class, $type);
    }

    protected function registerViewType(string $class, string $type)
    {
        Taskday::registerViewType($class, $type);
    }

    protected function registerAction(string $class, string $type)
    {
        Taskday::registerAction($class, $type);
    }
}
