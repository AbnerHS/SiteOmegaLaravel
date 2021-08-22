<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string("tituloObra");
            $table->string("capaObra");
            $table->string("tipoObra",50);
            $table->string("tituloAlternativo",50)->nullable();
            $table->string("lancamentoObra",20);
            $table->mediumText("sinopseObra");
            $table->string("status",50);
            $table->integer("views")->default(0);
            $table->foreignId("idScan")->nullable()->constrained('scans')
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
        Schema::dropIfExists('obras');
    }
}
