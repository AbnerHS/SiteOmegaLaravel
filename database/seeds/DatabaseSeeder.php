<?php

use App\Models\Artista;
use App\Models\Autor;
use App\Models\Genero;
use App\Models\Obra;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Autor::class, 10)->create();
        factory(Artista::class, 10)->create();
        factory(Genero::class, 10)->create();
        factory(Obra::class, 30)->create();
        factory(User::class, 10)->create();
    }
}
