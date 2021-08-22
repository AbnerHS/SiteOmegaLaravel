<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = ["nomeScan","logo","discord","twitter","facebook","instagram"];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function obra(){
        return $this->hasMany(Obra::class);
    }
}
