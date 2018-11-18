<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;

use App\Http\Requests\API\User\IndexUsers;
use App\Http\Requests\API\User\StoreUser;
use App\Http\Requests\API\User\UpdateUser;
use App\Http\Requests\API\User\DestroyUser;

use App\Http\Responses\API\User\UserIndexResponse;
use App\Http\Responses\API\User\UserStoredResponse;
use App\Http\Responses\API\User\UserShowResponse;
use App\Http\Responses\API\User\UserUpdatedResponse;
use App\Http\Responses\API\User\UserDeletedResponse;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\API\User\IndexUsers $request
     * @return \App\Http\Responses\API\User\UserIndexResponse
     */
    public function index(IndexUsers $request)
    {
        $key_name = with(new User)->getKeyName();
        $users_query = User::with(['role', 'group'])->orderBy($key_name);
        ['query' => $search_query, 'roles' => $roles, 'state' => $state] = $request;

        if (!empty($search_query)) {
            $users_query = $users_query->where(function ($query) use ($search_query) {
                $query->where('first_name', 'ilike', "%{$search_query}%")
                    ->orWhere('last_name', 'ilike', "%{$search_query}%")
                    ->orWhere('email', 'ilike', "%{$search_query}%");
            });
        }

        if (!empty($roles)) {
            $users_query->whereHas('role', function (Builder $role_query) use ($roles) {
                $role_key_name = with(new Role)->getKeyName();
                $role_query->whereIn($role_key_name, $roles);
            });
        }

        if (!empty($state)) {
            $users_query->where(function ($query) use ($state) {
                $query->where('state', $state);
            });
        }

        $users = $users_query->paginate($request->get('per_page'));

        return new UserIndexResponse($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\API\User\StoreUser $request
     * @return \App\Http\Responses\API\User\UserStoredResponse
     */
    public function store(StoreUser $request)
    {
        $data = array_except($request->validated(), ['role']);
        $data['password'] = Hash::make($data['password']);

        $user = new User($data);
        $user->role()->associate(Role::find($request->role));
        $user->group()->associate(Group::find($request->group));
        $user->save();

        return new UserStoredResponse($user->load(['role', 'group']));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \App\Http\Responses\API\User\UserShowResponse
     */
    public function show(User $user)
    {
        return new UserShowResponse($user->load(['role', 'group']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\API\User\UpdateUser $request
     * @param \App\Models\User $user
     * @return \App\Http\Responses\API\User\UserUpdatedResponse
     */
    public function update(UpdateUser $request, User $user)
    {
        $data = array_except($request->validated(), ['role', 'group']);

        if ($request->has('role')) {
            $role = Role::find($request->role);
            $can_change_role = Auth::user()->can('changeRole', [$user, $role]);

            if ($can_change_role) {
                $user->role()->associate($role);
            }
        }

        if ($request->has('group')) {
            $user->group()->associate(Group::find($request->group));
        }

        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return new UserUpdatedResponse($user->load(['role', 'group']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\API\User\DestroyUser $request
     * @param \App\Models\User $user
     * @return \App\Http\Responses\API\User\UserDeletedResponse|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(DestroyUser $request, User $user)
    {
        $user->delete();

        return new UserDeletedResponse();
    }
}
