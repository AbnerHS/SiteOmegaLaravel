<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;

class CheckIsVip
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
        if(auth()->user()){
            $doacao = auth()->user()->doacaos();
            if($doacao->exists()){
                $date = new DateTime($doacao->latest()->first()->created_at);
                $date = $date->format('Y-m-d');
                $atual = date('Y-m-d');
                $dif = strtotime($atual) - strtotime($date);
                $dif = $dif/(60*60*24);
                if($dif < 31){
                    $_COOKIE['vip'] = true;
                }
            }
        }
        return $next($request);
    }
}
