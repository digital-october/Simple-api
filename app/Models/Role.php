<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public static $root = 'root';
    public static $administrator = 'administrator';
    public static $manager = 'manager';
    public static $client = 'client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name'
    ];

    /**
     * Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check role.
     *
     * @param $role
     *
     * @return bool
     */
    public function isRole($role)
    {
        return $this->slug === ($role instanceof self ? $role->slug : $role);
    }

    /**
     * IsRoot attribute getter.
     *
     * @return bool
     */
    public function getIsRootAttribute()
    {
        return $this->isRole(self::$root);
    }

    /**
     * IsAdministrator attribute getter.
     *
     * @return bool
     */
    public function getIsAdministratorAttribute()
    {
        return $this->isRole(self::$administrator);
    }

    /**
     * IsManager attribute getter.
     *
     * @return bool
     */
    public function getIsManagerAttribute()
    {
        return $this->isRole(self::$manager);
    }

    /**
     * IsClient attribute getter.
     *
     * @return bool
     */
    public function getIsClientAttribute()
    {
        return $this->isRole(self::$client);
    }

    /**
     * Scope a query to only include a given role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Models\Role|string $role
     *
     * @return mixed
     */
    public function scopeWhereRole(Builder $query, $role)
    {
        $slug = $role instanceof self ? $role->slug : $role;

        return $query->whereSlug($slug);
    }

    /**
     * Scope a query to only include a root role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeRoot(Builder $query)
    {
        return $query->whereRole(self::$root);
    }

    /**
     * Scope a query to only include an administrator role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeAdministrator(Builder $query)
    {
        return $query->whereRole(self::$administrator);
    }

    /**
     * Scope a query to only include a manager role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeManager(Builder $query)
    {
        return $query->whereRole(self::$manager);
    }

    /**
     * Scope a query to only include a client role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return mixed
     */
    public function scopeClient(Builder $query)
    {
        return $query->whereRole(self::$client);
    }
}
