<?php

namespace Taskday;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Taskday\Models\Team;

class TaskdayServiceProvider extends ServiceProvider
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
        Taskday\Models\Team::class => Taskday\Policies\TeamPolicy::class,
    ];

    /**
     * We register all the services we need.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('taskday', function () {
            return new Taskday();
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'taskday');

        $this->registerBladeDirectives();
        $this->registerPolicies();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerMigrations();
    }

    public function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'taskday');
    }

    public function registerMigrations(): void
    {
        if ($this->app->runningInConsole()) {
            foreach ([
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
                '20_add_team_id_to_workspaces_table',
            ] as $value) {

                $migration = __DIR__ . "/../database/migrations/$value.php.stub";

                $published = collect(glob(database_path('migrations/*')))
                    ->filter(fn ($path) => $path == $migration)
                    ->isNotEmpty();

                if (! $published) {
                    $this->publishes([
                        __DIR__ . "/../database/migrations/$value.php.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . "$value.php"),
                    ], 'migrations');
                }
            }
          }
    }

    public function registerRoutes(string $prefix = ''): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    protected function registerBladeDirectives(): void
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
