<?php

use Faker\Generator as Faker;

$factory->define(App\Language::class, function (Faker $faker) {
    return [
        'description' => $faker->realText(random_int(16, 32))
    ];
});
