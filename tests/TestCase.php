<?php

namespace Tests;

use CreatePermissionTables;
use Illuminate\Support\Facades\Event;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Laravel\Fortify\FortifyServiceProvider;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\JetstreamServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\PermissionServiceProvider;
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
            PermissionServiceProvider::class,
            TaskdayServiceProvider::class,
            InertiaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('taskday.user.model', \Taskday\Models\User::class);
        config()->set('auth.providers.0.model', \Taskday\Models\User::class);
        config()->set('auth.providers.0.guard', 'sanctum');

        config()->set('inertia.testing.page_paths', [
            __DIR__ . '/../resources/views',
        ]);

        Jetstream::useUserModel(\Taskday\Models\User::class);

        app(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        foreach(glob(__DIR__ . '/../database/migrations/*.stub') as $path) {
            $migration = include $path;
            $migration->up();
        }
    }
}
