<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Obra;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Obra::class, function (Faker $faker) {
    return [
        'tituloObra' => Str::random(10),
        'capaObra' => 'obras/capa.jpg', 
        'tipoObra' => 'Mangá',
        'lancamentoObra' => $this->faker->date(),
        'sinopseObra' => $this->faker->paragraph,
        'status' => 'Lancamento'
    ];
});
