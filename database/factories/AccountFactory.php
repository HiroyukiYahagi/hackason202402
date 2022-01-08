<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use App\Models\Property;
use App\Models\Label;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "hash" => \Str::random(16),
        "reply_token" => \Str::random(24)
    ];
});

$factory->afterCreating(Account::class, function ($account, $faker) {
    $thumbnail = Label::firstOrCreate([ "name" => "thumbnail" ]);
    $pet_names = Label::firstOrCreate([ "name" => "pet_names" ]);

    $account->properties()->create([
        "label_id" => $thumbnail->id,
        "val" => $faker->url
    ]);

    $account->properties()->create([
        "label_id" => $pet_names->id,
        "val" => $faker->userName
    ]);
    $account->properties()->create([
        "label_id" => $pet_names->id,
        "val" => $faker->userName
    ]);
    $account->properties()->create([
        "label_id" => $pet_names->id,
        "val" => $faker->userName
    ]);
});
