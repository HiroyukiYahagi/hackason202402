<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Senario;
use App\Models\Bot;
use Faker\Generator as Faker;

$factory->define(Senario::class, function (Faker $faker) {
    $bot = factory(Bot::class)->create();
    return [
        "bot_id" => $bot->id,
        "condition" => "return true;",
        "name" => $faker->userName,
        "priority" => 100,
        "is_valid" => 1,
    ];
});
