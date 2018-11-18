<?php

namespace App\Models;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Role relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Group relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Determine whether the user has role.
     *
     * @param $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role->isRole($role);
    }

    /**
     * Determine if the user is root.
     *
     * @return bool
     */
    public function getIsRootAttribute()
    {
        return $this->role->is_root;
    }

    /**
     * Determine if the user is administrator.
     *
     * @return bool
     */
    public function getIsAdministratorAttribute()
    {
        return $this->role->is_administrator;
    }

    /**
     * Determine if the user is manager.
     *
     * @return bool
     */
    public function getIsManagerAttribute()
    {
        return $this->role->is_manager;
    }

    /**
     * Determine if the user is client.
     *
     * @return bool
     */
    public function getIsClientAttribute()
    {
        return $this->role->is_client;
    }

    /**
     * Scope a query to include users with given role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Models\Role|string $role
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasRole(Builder $query, $role)
    {
        return $query->whereHas('role', function (Builder $role_query) use ($role) {
            $role_query->whereRole($role);
        });
    }

    /**
     * Scope a query to include only users with root role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRoot(Builder $query)
    {
        return $query->hasRole(Role::$root);
    }

    /**
     * Scope a query to include only users with administrator role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdministrator(Builder $query)
    {
        return $query->hasRole(Role::$administrator);
    }

    /**
     * Scope a query to include only users with manager role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManager(Builder $query)
    {
        return $query->hasRole(Role::$manager);
    }

    /**
     * Scope a query to include only users with client role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClient(Builder $query)
    {
        return $query->hasRole(Role::$client);
    }
}
