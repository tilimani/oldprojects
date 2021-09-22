<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'gender' => $faker->randomElement($array = array ('m', 'f')),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'language_id' => function () {
            return factory(App\Language::class)->create()->id;
        },
        'nationality_id' => function () {
            return factory(App\Nationality::class)->create()->id;
        },
        'profession_id' => function () {
            return factory(App\Profession::class)->create()->id;
        },
        'birthdate' => $faker->date()
    ];
});