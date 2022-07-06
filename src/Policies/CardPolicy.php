<?php

namespace Taskday\Policies;

use Taskday\Models\Card;
use Illuminate\Auth\Access\HandlesAuthorization;

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
    public function view($user, Card $card)
    {
        if ($card->project->ownerIs($user)) {
            return true;
        }


        if ( $card->project->hasMember($user) ) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  User  $user
     * @param  Card  $card
     * @return mixed
     */
    public function update($user, Card $card)
    {
        if ($card->project->ownerIs($user)) {
            return true;
        }


        if ( $card->project->hasMember($user) ) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  User  $user
     * @param  Card  $card
     * @return mixed
     */
    public function delete($user, Card $card)
    {
        if ($user->can('delete cards')) {
            return true;
        }

        if ($card->project->ownerIs($user)) {
            return true;
        }


        if ( $card->project->hasMember($user) ) {
            return true;
        }
    }
}
