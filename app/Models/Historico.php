<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $fillable = ['capitulo_id','user_id','obra_id','created_at','updated_at'];

    public function capitulo(){
        return $this->belongsTo(Capitulo::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function obra(){
        return $this->belongsTo(Obra::class);
    }
}
