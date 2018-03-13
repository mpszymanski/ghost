<?php

use Faker\Generator as Faker;

$factory->define(App\Place::class, function (Faker $faker) {
	$lat = rand(49732833, 53924965) / pow(10, 6);
	$lng = rand(14469480, 23714003) / pow(10, 6);

    return [
		'name' => $faker->realText(40),
		'lat' => $lat,
		'lng' => $lng,
    ];
});
