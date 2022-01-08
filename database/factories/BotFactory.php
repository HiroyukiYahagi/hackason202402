<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Bot;
use Faker\Generator as Faker;

$factory->define(Bot::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "line_account_name" => $faker->name,
        "hash" => \Str::random(12),
        "channel_access_token" => \Str::random(12),
    ];
});
