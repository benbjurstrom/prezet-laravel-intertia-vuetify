<?php

use App\Models\Team;
use Illuminate\Support\Str;
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

$factory->define(Team::class, function (Faker $faker) {
    $company = $faker->company;
    return [
        'name' => $faker->company,
        'slug' => strtolower(Str::slug($company))
    ];
});
