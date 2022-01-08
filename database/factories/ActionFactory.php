<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Action;
use App\Models\Rule;
use Faker\Generator as Faker;

$factory->define(Action::class, function (Faker $faker) {
    $rule = factory(Rule::class)->create();
    return [
        "rule_id" => $rule->id,
        "body" => "return true;",
        "name" => $faker->userName,
        "order" => 100
    ];
});
