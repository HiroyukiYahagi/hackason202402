<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Senario;
use App\Models\Rule;
use Faker\Generator as Faker;

$factory->define(Rule::class, function (Faker $faker) {
    $senario = factory(Senario::class)->create();
    return [
        "senario_id" => $senario->id,
        "condition" => "return true;",
        "name" => $faker->userName,
        "rule_type" => Rule::REPLY,
        "priority" => 100,
        "is_valid" => 1,
    ];
});
