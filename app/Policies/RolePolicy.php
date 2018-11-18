<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Role;

class RolePolicy
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
     * Determine whether the user can index the Roles.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->is_manager;
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        //
    }
}
