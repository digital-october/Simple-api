<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Role;

class UserPolicy
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
        if ($user->is_root || $user->is_administrator) {
            return true;
        }
    }

    /**
     * Determine whether the user can index the Users.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->is_manager;
    }

    /**
     * Determine whether the user can view the User.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create Users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the User.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->is_root || $user->is_administrator;
    }

    /**
     * Determine whether the user can update the Role another User.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $another_user
     * @param \App\Models\Role $role
     * @return bool
     */
    public function changeRole(User $user, User $another_user, Role $role)
    {
        return !$user->is($another_user);
    }

    /**
     * Determine whether the user can delete the User.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
    }
}
