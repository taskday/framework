<?php

namespace Taskday\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Taskday\Models\Field;

class FieldPolicy
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
        if ($user->can('view fields')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\User|null $user
     * @param  Field  $field
     * @return mixed
     */
    public function view(?User $user, Field $field)
    {
        if ($user->can('view fields')) {
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
        if ($user->can('create fields')) {
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
    public function update(User $user, Field $field)
    {
        if ($user->can('edit fields')) {
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
    public function delete(User $user, Field $field)
    {
        if ($user->can('delete fields')) {
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
    public function restore(User $user, Field $field)
    {
        if ($user->can('restore fields')) {
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
    public function forceDelete(User $user, Field $field)
    {
        if ($user->can('force delete fields')) {
            return true;
        }
    }
}
