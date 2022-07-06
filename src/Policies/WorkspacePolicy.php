<?php

namespace Taskday\Policies;

use App\Models\User;
use Taskday\Models\Workspace;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class WorkspacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\User|null $user
     * @param  Field  $field
     * @return mixed
     */
    public function view(?User $user, Workspace $workspace)
    {
        if ($workspace->ownerIs($user)) {
            return true;
        }


        if ($workspace->hasMember($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->can('create workspace')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\User  $user
     * @param  Field  $field
     * @return mixed
     */
    public function update(User $user, Workspace $workspace)
    {
        if ($workspace->ownerIs($user)) {
            return true;
        }


        if ($workspace->hasMember($user) && $user->can('update workspaces')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  Field  $field
     * @return mixed
     */
    public function delete(User $user, Workspace $workspace)
    {
        if ($workspace->ownerIs($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\Models\User  $user
     * @param  Field  $field
     * @return mixed
     */
    public function restore(User $user, Workspace $workspace)
    {
        if ($workspace->ownerIs($user)) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  Field  $field
     * @return mixed
     */
    public function forceDelete(User $user, Workspace $workspace)
    {
        if ($workspace->ownerIs($user)) {
            return true;
        }
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
        if ($workspace->ownerIs($user)) {
            return true;
        }
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
        if ($workspace->ownerIs($user)) {
            return true;
        }
    }
}
