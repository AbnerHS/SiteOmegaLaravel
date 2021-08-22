<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $fillable = ['user_id','obra_id','created_at','updated_at'];

    public function obra(){
        return $this->belongsTo(Obra::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
