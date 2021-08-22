<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistaObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artista__obras', function (Blueprint $table) {
            $table->foreignId('idArtista')->constrained('artistas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('idObra')->constrained('obras')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artista__obras');
    }
}
