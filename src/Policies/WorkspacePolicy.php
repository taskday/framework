<?php

namespace Taskday\Policies;

use Taskday\Models\Workspace;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class WorkspacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the workspace.
     *
     * @param  User  $user
     * @param  Workspace  $workspace
     * @return mixed
     */
    public function view(Model $user, Workspace $workspace)
    {
        return $workspace->ownerIs($user) || $workspace->hasMember($user);
    }

    /**
     * Determine whether the user can update the workspace.
     *
     * @param  User  $user
     * @param  Workspace  $workspace
     * @return mixed
     */
    public function update(Model $user, Workspace $workspace)
    {
        return $workspace->ownerIs($user) || $workspace->hasMember($user);
    }

    /**
     * Determine whether the user can delete the workspace.
     *
     * @param  User  $user
     * @param  Workspace  $workspace
     * @return mixed
     */
    public function delete(Model $user, Workspace $workspace)
    {
        return $workspace->ownerIs($user);
    }

    /**
     * Determine whether the user can share the workspace.
     *
     * @param  User  $user
     * @param  Workspace  $workspace
     * @return mixed
     */
    public function share(Model $user, Workspace $workspace)
    {
        return $workspace->ownerIs($user);
    }

    /**
     * Determine whether the user can unshare the workspace.
     *
     * @param  User  $user
     * @param  Workspace  $workspace
     * @return mixed
     */
    public function unshare(Model $user, Workspace $workspace)
    {
        return $workspace->ownerIs($user);
    }
}
