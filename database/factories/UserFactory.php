<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'password' => bcrypt(1234),
        'tipo_usuario' => 1
    ];
});
