<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NotificaCapitulo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $notificacao = 0;
        if($user = Auth::user()){
            $favoritos = $user->favoritos()->get();
            foreach($favoritos as $fav){
                $obra = $fav->obra()->first();
                $capitulos = $obra->capitulos()->where('created_at','>=',$fav->created_at)->get();
                foreach($capitulos as $cap){
                    if(!$user->historicos()->where('capitulo_id',$cap->id)->exists()){
                        $notificacao++;
                    }
                }
            }
        }
        $_COOKIE['notificacao'] = $notificacao;
        return $next($request);
    }
}