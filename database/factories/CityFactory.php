<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {	
    return [
        'name' =>$faker->city,
        'latitude' => $faker->latitude($min = -90, $max = 90),
        'longitude' => $faker->longitude($min = -180, $max = 180),
        'region_id' => function () {
            return factory(App\Models\Region::class)->create()->id;
        },
    ];
});
