<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createForRoles(Role::all());
        $this->createClients();
    }

    /**
     * Create users for given roles.
     *
     * @param \Illuminate\Support\Collection $roles
     */
    public function createForRoles(Collection $roles)
    {
        foreach ($roles as $role) {
            $this->createForRole($role);
        }
    }

    /**
     * Create User with given data and role.
     *
     * @param \App\Models\Role $role
     * @param array $data
     * @return bool
     */
    public function createForRole(Role $role, array $data = []): bool
    {
        $domain = config('app.domain');
        $email = $role->slug.'@'.$domain;
        $data = array_merge([
            'email' => $email,
        ], $data);

        return $this->make($data, [])
            ->role()->associate($role)
            ->save();
    }

    /**
     * Create given amount of fake clients.
     *
     * @param int $count
     */
    public function createClients(int $count = 10)
    {
        $client_role = Role::whereSlug('client')->first();
        $groups = Group::all();

        factory(User::class, $count)->make()
            ->each(function (User $user) use ($client_role, $groups) {
                $user->role()->associate($client_role);
                $user->group()->associate($groups->random(1)->first());
                $user->save();
            });
    }

    /**
     * Make User instance filled with given data and states.
     *
     * @param array $data
     * @param array $states
     * @return \App\Models\User
     */
    public function make(array $data, array $states = []): User
    {
        return factory(User::class)->states($states)->make($data);
    }
}
