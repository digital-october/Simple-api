<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;

use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\GroupPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Group::class => GroupPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('users.index', [new UserPolicy, 'index']);
        Gate::resource('users', UserPolicy::class);

        Gate::resource('roles', RolePolicy::class);

        Gate::define('groups.index', [new GroupPolicy, 'index']);
        Gate::resource('groups', GroupPolicy::class);
    }
}
