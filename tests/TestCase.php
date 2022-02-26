<?php

namespace Tests;

use Inertia\ServiceProvider as InertiaServiceProvider;
use Laravel\Fortify\FortifyServiceProvider;
use Laravel\Jetstream\JetstreamServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Taskday\Taskday;
use Taskday\TaskdayServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ActivitylogServiceProvider::class,
            FortifyServiceProvider::class,
            JetstreamServiceProvider::class,
            SanctumServiceProvider::class,
            TaskdayServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Tests\Http\Kernel');
    }


    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('taskday.user.model', \Taskday\Models\User::class);
        config()->set('auth.providers.0.model', \Taskday\Models\User::class);

        config()->set('inertia.testing.page_paths', [
            __DIR__.'/../resources/views',
        ]);

        foreach(glob(__DIR__ . '/../database/migrations/*.stub') as $path) {
            $migration = include $path;
            $migration->up();
        }
    }
}
