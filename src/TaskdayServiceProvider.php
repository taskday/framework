<?php

namespace Taskday;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TaskdayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('taskday')
            ->hasConfigFile('taskday')
            ->hasMigrations('',
                '6_create_workspaces_table',
                '7_create_projects_table',
                '8_create_cards_table',
                '9_create_members_table',
                '10_create_fields_table',
                '11_create_field_project_table',
                '12_create_card_field_table',
                '13_create_teams_table',
                '14_create_team_user_table',
                '15_create_team_invitations_table',
                '16_create_comments_table',
                '18_create_push_subscriptions_table',
                '19_create_notifications_table',
                '20_create_media_table',
                '21_create_activity_log_table',
                '22_add_event_column_to_activity_log_table',
                '23_add_batch_uuid_column_to_activity_log_table',
            )
            ->hasViews('taskday');
    }


    public function packageRegistered()
    {
        Route::macro('taskday', function (string $prefix = 'taskday') {
            Route::prefix($prefix)->middleware('web')->group(function () {
                require_once __DIR__ . '/../routes/web.php';
            });
            Route::prefix($prefix . '/api')->middleware('api')->group(function () {
                require_once __DIR__ . '/../routes/api.php';
            });
        });
    }


    public function registeringPackage()
    {
        // Register the main class to use with the facade
        $this->app->singleton('taskday', function () {
            return new Taskday();
        });
    }


    public function bootingPackage()
    {
        $this->registerBladeDirectives();
    }


    protected function registerBladeDirectives()
    {
        Blade::directive('taskdayStyles', function ($expression) {
            return <<<EOT
            <?php
                // foreach(\Taskday\Facades\Taskday::getStyles() as \$style) {
                //     echo "<link rel='stylesheet' href='/styles/\$style' />";
                // }
            ?>
            EOT;
        });

        Blade::directive('taskdayScripts', function ($expression) {
            return <<<EOT
            <?php
                foreach(\Taskday\Facades\Taskday::plugins() as \$plugin) {
                    echo "<script type='module' src='/scripts/\$plugin->handle'></script>";
                }
            ?>
            EOT;
        });
    }
}
