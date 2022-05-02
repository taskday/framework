<?php

namespace Taskday\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Taskday\Models\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function view(Model $user, Project $project)
    {
        return $project->ownerIs($user) || $project->hasMember($user) || $project->workspace->team_id == $user->current_team_id;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function update(Model $user, Project $project)
    {
        return $project->ownerIs($user) || $project->hasMember($user) || $project->workspace->team_id == $user->current_team_id;
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function delete(Model $user, Project $project)
    {
        return $project->ownerIs($user);
    }

    /**
     * Determine whether the user can permanently delete the workspace.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function share(Model $user, Project $project)
    {
        return $project->ownerIs($user);
    }

    /**
     * Determine whether the user can unshare the workspace.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function unshare(Model $user, Project $project)
    {
        return $project->ownerIs($user);
    }
}
