<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsStaff
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
        $user = auth()->user();
        if($user->tipo_usuario != 1 && $user->tipo_usuario != 2 && $user->tipo_usuario != 4){
            return redirect('/');
        }
        return $next($request);
    }
}
