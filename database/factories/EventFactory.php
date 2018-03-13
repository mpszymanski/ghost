<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    $limit = rand(3, 16);
    $date = $faker->dateTimeBetween($startDate = '+2 weeks', $endDate = '+3 months', $timezone = null);
    $time1 = $faker->time($format = 'H:i:s');
    $time2 = $faker->time($format = 'H:i:s');
    $c = Carbon::instance($date);
    $deadline = $c->subDays(rand(1, 7));
    $users = App\User::all(['id'])->pluck('id');

    return [
        'user_id' => $users->random(),
        'name' => $faker->realText(40),
        'description' => $faker->realText(255, 3),
        'start_date' => $date,
        'end_date' => $date,
        'start_time' => $time1 < $time2 ? $time1 : $time2,
        'end_time' => $time1 < $time2 ? $time2 : $time1,
        'register_deadline' => $deadline,
        'participants_limit' => $limit,
        'is_public' => 1,
    ];
});
