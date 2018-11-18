<?php

use Illuminate\Database\Seeder;

use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public static $roles = [
        'root' => 'Root',
        'administrator' => 'Administrator',
        'manager' => 'Manager',
        'client' => 'Client'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = self::$roles;

        foreach ($roles as $slug => $name) {
            $this->create([
                'slug' => $slug,
                'name' => $name
            ]);
        }
    }

    /**
     * Create Role with given data.
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data) : bool
    {
        return $this->make($data)->save();
    }

    /**
     * Make Role instance filled with given data.
     *
     * @param array $data
     * @return \App\Models\Role
     */
    public function make(array $data) : Role
    {
        return new Role($data);
    }
}
