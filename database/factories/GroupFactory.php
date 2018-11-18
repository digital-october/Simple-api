<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->words(random_int(1, 3), true)
    ];
});
