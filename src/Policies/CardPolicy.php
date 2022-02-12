<?php

namespace Performing\Taskday\Policies;

use Performing\Taskday\Models\Card;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class CardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  User  $user
     * @param  Card  $card
     * @return mixed
     */
    public function view(Model $user, Card $card)
    {
        return $card->project->ownerIs($user) || $card->project->hasMember($user);
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  User  $user
     * @param  Card  $card
     * @return mixed
     */
    public function update(Model $user, Card $card)
    {
        return $card->project->ownerIs($user) || $card->project->hasMember($user);
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  User  $user
     * @param  Card  $card
     * @return mixed
     */
    public function delete(Model $user, Card $card)
    {
        return $card->project->ownerIs($user) || $card->project->hasMember($user);
    }
}
