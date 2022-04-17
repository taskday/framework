<?php

namespace Taskday;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TaskdayServiceProvider extends PackageServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Taskday\Models\Project::class => Taskday\Policies\ProjectPolicy::class,
        Taskday\Models\Workspace::class => Taskday\Policies\WorkspacePolicy::class,
        Taskday\Models\Card::class => Taskday\Policies\CardPolicy::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('taskday')
            ->hasConfigFile('taskday')
            ->hasMigrations(
                '06_create_workspaces_table',
                '07_create_projects_table',
                '08_create_cards_table',
                '09_create_members_table',
                '10_create_fields_table',
                '11_create_field_project_table',
                '12_create_card_field_table',
                '13_create_teams_table',
                '14_create_team_user_table',
                '15_create_team_invitations_table',
                '16_create_comments_table',
                '17_create_push_subscriptions_table',
                '18_create_notifications_table',
                '19_create_media_table',
                '20_create_activity_log_table',
                '21_add_event_column_to_activity_log_table',
                '22_add_batch_uuid_column_to_activity_log_table',
                '22_add_batch_uuid_column_to_activity_log_table',
                '23_add_team_id_to_projects_and_workspaces_table',
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
        $this->registerPolicies();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('taskday', function ($expression) {
            return <<<EOT
            <?php
                foreach(\Taskday\Facades\Taskday::plugins() as \$plugin) {
                    echo "<link rel='stylesheet' href='/styles/\$plugin->handle' />";
                    echo "<script type='module' src='/scripts/\$plugin->handle'></script>";
                }
            ?>
            EOT;
        });
    }
}
