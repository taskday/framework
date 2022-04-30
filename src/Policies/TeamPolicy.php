<?php

namespace Taskday\Policies;

use Taskday\Models\Team;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Taskday\Models\User  $user
     * @return mixed
     */
    public function viewAny($user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Taskday\Models\User  $user
     * @param  \Taskday\Models\Team  $team
     * @return mixed
     */
    public function view($user, Team $team)
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Taskday\Models\User  $user
     * @return mixed
     */
    public function create($user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Taskday\Models\User  $user
     * @param  \Taskday\Models\Team  $team
     * @return mixed
     */
    public function update($user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can add team members.
     *
     * @param  \Taskday\Models\User  $user
     * @param  \Taskday\Models\Team  $team
     * @return mixed
     */
    public function addTeamMember($user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can update team member permissions.
     *
     * @param  \Taskday\Models\User  $user
     * @param  \Taskday\Models\Team  $team
     * @return mixed
     */
    public function updateTeamMember($user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     *
     * @param  \Taskday\Models\User  $user
     * @param  \Taskday\Models\Team  $team
     * @return mixed
     */
    public function removeTeamMember($user, Team $team)
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Taskday\Models\User  $user
     * @param  \Taskday\Models\Team  $team
     * @return mixed
     */
    public function delete($user, Team $team)
    {
        return $user->ownsTeam($team);
    }
}
