<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Group;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize the action before the intended policy method is actually called.
     *
     * @param \App\Models\User $user
     * @param $ability
     * @return mixed
     */
    public function before(User $user, $ability)
    {
        return $user->is_root || $user->is_administrator;
    }

    /**
     * Determine whether the user can index the Groups.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->is_manager;
    }

    /**
     * Determine whether the user can view the Group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        //
    }

    /**
     * Determine whether the user can create Groups.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the Group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        //
    }

    /**
     * Determine whether the user can delete the Group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        //
    }
}
