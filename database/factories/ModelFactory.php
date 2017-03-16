<?php

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | Here you may define all of your model factories. Model factories give
  | you a convenient way to create models for testing and seeding your
  | database. Just tell the factory how a default model should look.
  |
 */

use CodeProject\Entities\Eloquent\User;
use CodeProject\Entities\Eloquent\Client;
use CodeProject\Entities\Eloquent\Project;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});


$factory->define(Project::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'progress' => $faker->numberBetween(0, 100),
        'status' => $faker->numberBetween(1, 5),
        'due_date' => $faker->dateTime,
        'owner_id' => $faker->numberBetween(1, 100),
        'client_id' => $faker->numberBetween(1, 100)
    ];
});
