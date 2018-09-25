<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(CodeProject\Entities\Eloquent\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeProject\Entities\Eloquent\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(\CodeProject\Entities\Eloquent\Project::class, function (Faker $faker) {
    return [
        'owner_id' => $faker->numberBetween(1, 10),
        'client_id' => $faker->numberBetween(1, 10),
        'name' => $faker->name,
        'description' => $faker->sentence,
        'progress'=> $faker->numberBetween(0, 100),
        'status' => $faker->numberBetween(1, 5),
        'due_date' => $faker->dateTime
    ];
});

$factory->define(\CodeProject\Entities\Eloquent\ProjectNote::class, function (Faker $faker) {
    return [
        'project_id' => $faker->numberBetween(1, 10),
        'title' => $faker->sentence,
        'note' => $faker->paragraph
    ];
});

$factory->define(\CodeProject\Entities\Eloquent\ProjectTask::class, function (Faker $faker) {
    return [
        'project_id' => $faker->numberBetween(1, 10),
        'name' => $faker->name,
        'start_date' => $faker->date(),
        'due_date' => $faker->date(),
        'status' => $faker->numberBetween(1, 5)
    ];
});

$factory->define(\CodeProject\Entities\Eloquent\ProjectMembers::class, function (Faker $faker) {
    return [
        'project_id' => $faker->numberBetween(1, 10),
        'user_id' => $faker->numberBetween(1, 10)
    ];
});