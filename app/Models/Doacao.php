<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doacao extends Model
{
    protected $fillable = ['valor', 'user_id','created_at'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
