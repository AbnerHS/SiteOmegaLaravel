<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Obra extends Model
{
    protected $fillable = ["tituloObra","capaObra","tipoObra","tituloAlternativo",
    "lancamentoObra","sinopseObra","status","data_capitulo"];
    
    public function search($filter = null, $order = null, $genero = null){
        if($order == 'favoritos')
            $results = Obra::select(DB::raw('obras.id,obras.tituloObra,obras.capaObra, count(favoritos.id) as fav'));
        else if($order == 'avaliacao')
            $results = Obra::select(DB::raw('obras.id,obras.tituloObra,obras.capaObra, avg(avaliacaos.nota) as media'));
        else
            $results = Obra::select(DB::raw('obras.id,obras.tituloObra,obras.capaObra'));
        if($filter)
            $results->where('tituloObra','LIKE',"%{$filter}%");
        if(!empty($genero)){
            $results->join('genero__obras','idObra','=','obras.id')
                ->join('generos','idGenero','=','generos.id')
                ->where('generos.nome','=',$genero);
        }
        if($order == 'favoritos'){
            $results->leftJoin('favoritos','obras.id','=','favoritos.obra_id')
            ->groupBy('obras.id','obras.tituloObra','obras.capaObra')
            ->orderBy('fav','desc');
        }
        if($order == 'avaliacao'){
            $results->leftJoin("avaliacaos","obras.id","=","avaliacaos.idObra")
            ->groupBy("obras.id","obras.tituloObra","obras.capaObra")
            ->orderBy('media','desc');
        }
        if($order == 'a-z')
            $results->orderBy("tituloObra","asc");
        if($order == 'views')
            $results->orderBy("views","desc");
        return $results->get();
    }

    public function searchField($filter = null){
        $results = $this->where(function($query) use ($filter){
            if($filter){
                $query->where("tituloObra","LIKE","%{$filter}%");
            }
        })->select("id","tituloObra","capaObra","status")->orderBy("tituloObra","asc")->limit(10)->get();
        return $results;
    }

    public function capitulos(){
        return $this->hasMany(Capitulo::class, 'idObra');
    }

    public function scan(){
        return $this->belongsTo(Scan::class);
    }

    public function favoritos(){
        return $this->hasMany(Favorito::class);
    }

    public function historicos(){
        return $this->hasMany(Historico::class);
    }
}
