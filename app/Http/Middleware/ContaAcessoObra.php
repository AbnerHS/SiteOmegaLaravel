<?php

namespace App\Http\Middleware;

use App\Models\Capitulo;
use App\Models\Obra;
use Closure;

class ContaAcessoObra
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
        $id = $request->route()->id;
        $numCap = $request->route()->cap;
        $obra = Obra::find($id);
        $capitulo = Capitulo::where([['idObra',$id],['numCapitulo',$numCap]])->first();
        $capitulo->increment('views');
        $obra->increment('views');
        return $next($request);
    }
}
