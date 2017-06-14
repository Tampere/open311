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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker) {
    return [
        'service_code' => $faker->uuid,
        'service_name' => $faker->unique()->company,
        'description' => $faker->paragraph,
        'group' => $faker->company,
    ];
});

$factory->define(App\Request::class, function (Faker\Generator $faker) {
    return [
        'service_code' => function() {
            return factory(App\Service::class)->create()->service_code;
        },
        'status' => $faker->randomElement(['open', 'closed']),
        'agency_responsible' => $faker->company,
        'description' => $faker->paragraph,
        'title' => $faker->sentence,
        'address_string' => $faker->streetAddress,
        'zip_code' => $faker->numberBetween(30000, 39999),
        'email' => $faker->safeEmail,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'media_url' => $faker->url,
        'location' => $faker->latitude . ', ' . $faker->longitude,
    ];
});