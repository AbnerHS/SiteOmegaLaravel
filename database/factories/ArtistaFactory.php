<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Artista;
use Faker\Generator as Faker;

$factory->define(Artista::class, function (Faker $faker) {
    return [
        'nome' => $this->faker->name
    ];
});
