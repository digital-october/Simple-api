<?php

use Illuminate\Database\Seeder;

use App\Models\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws \Exception
     */
    public function run()
    {
        $this->create(random_int(5, 10));
    }

    /**
     * Create fake data in the right amount
     *
     * @param int $count
     * @param array $data
     * @return mixed
     *
     */
    public function create(int $count = 5, array $data = [])
    {
        return factory(Group::class, $count)->create($data);
    }
}
