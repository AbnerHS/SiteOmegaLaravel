<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    protected $fillable = ['numCapitulo','idObra'];

    public function obras(){
        return $this->belongsTo('App\Models\Obra');
    }

    public function historicos(){
        return $this->hasMany(Historico::class);
    }
}
