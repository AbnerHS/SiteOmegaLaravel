<?php

namespace App\Http\Middleware;

use App\Models\Capitulo;
use App\Models\Historico;
use Closure;
use Illuminate\Support\Facades\Auth;

class LeituraCapitulo
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
        $capitulo = Capitulo::where([['idObra',$id],['numCapitulo',$numCap]])->first();
        if(Auth::user()){
            $user = Auth::user();
            $data = array(
                'user_id' => $user->id,
                'capitulo_id' => $capitulo->id,
                'obra_id' => $id
            );
            if($historico = $user->historicos()->where('capitulo_id',$capitulo->id)->exists())
                $user->historicos()->where('capitulo_id',$capitulo->id)->update($data);
            else
                $historico = Historico::create($data);
        }
        return $next($request);
    }
}
