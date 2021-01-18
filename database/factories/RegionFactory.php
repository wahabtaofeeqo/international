<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Region;
use Faker\Generator as Faker;

$factory->define(Region::class, function (Faker $faker) {
    return [
        'name' =>$faker->region,
        'country_id' => function () {
            return factory(App\Models\Country::class)->create()->id;
        },
    ];
});
