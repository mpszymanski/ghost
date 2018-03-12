<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
	$list = ['M','F'];
	$gander = $list[array_rand($list)];

    return [
        'nick' => $gander == 'M' ? $faker->firstNameMale : $faker->firstNameFemale,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'birth_date' => $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-18 years', $timezone = null),
		'gender' => $gander
    ];
});
