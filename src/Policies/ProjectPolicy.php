<?php

namespace Taskday\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
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
    public function view($user, Project $project)
    {
        if ($project->ownerIs($user)) {
            return true;
        }


        if ($project->hasMember($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function update($user, Project $project)
    {
        if ($project->ownerIs($user)) {
            return true;
        }

        if ($project->hasMember($user) && $user->can('update projects')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  User  $user
     * @param  Project  $project
     * @return mixed
     */
    public function delete($user, Project $project)
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
    public function share($user, Project $project)
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
    public function unshare($user, Project $project)
    {
        return $project->ownerIs($user);
    }
}
