<?php

namespace Tests;

use Inertia\ServiceProvider as InertiaServiceProvider;
use Laravel\Fortify\FortifyServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\JetstreamServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Taskday\Models\Team;
use Taskday\TaskdayServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Tests\Http\Kernel');
    }

    protected function getPackageProviders($app): array
    {
        return [
            FortifyServiceProvider::class,
            JetstreamServiceProvider::class,
            SanctumServiceProvider::class,
            TaskdayServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('taskday.user.model', \Taskday\Models\User::class);
        config()->set('auth.providers.0.model', \Taskday\Models\User::class);

        config()->set('inertia.testing.page_paths', [
            __DIR__ . '/../resources/views',
        ]);

        Jetstream::useUserModel(\Taskday\Models\User::class);

        foreach(glob(__DIR__ . '/../database/migrations/*.stub') as $path) {
            $migration = include $path;
            $migration->up();
        }
    }
}
