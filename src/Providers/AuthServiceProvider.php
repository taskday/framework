<?php

namespace Taskday\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
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
        Taskday\Models\Field::class => Taskday\Policies\FieldPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
