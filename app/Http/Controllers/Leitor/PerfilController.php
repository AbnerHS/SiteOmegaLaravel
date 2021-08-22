<?php

namespace App\Http\Controllers\Leitor;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use App\Models\Capitulo;
use App\Models\Historico;
use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('notifica.capitulo')->only('index');
        $this->middleware('check.is.vip')->only('index');
    }
    public function index(){
        $user = Auth::user();
        $favoritos = $user->favoritos()->get();
        $historicos = $user->historicos()->select(DB::raw('distinct(obra_id)'))->get();
        $obras = array();
        foreach($favoritos as $favorito)
            array_push($obras, Obra::find($favorito->obra_id));
        foreach($obras as $obra){
            $obra->capitulos = Capitulo::where('idObra','=',$obra->id)->orderBy('numCapitulo','desc')->limit(2)->get();
            $obra->nota = $this->nota($obra->id);
        }
        $leituras = array();
        foreach($historicos as $hist){
            $obra = Obra::find($hist->obra_id);
            array_push($leituras, $obra);
        }
        if($leituras != NULL){
            foreach($leituras as $leitura){
                $cap = $leitura->historicos()->where('user_id',$user->id)->latest()->first();
                $leitura['data'] = $cap->updated_at;
                $leitura['idHistorico'] = $cap->id;
                $cap = Capitulo::find($cap->capitulo_id);
                $leitura['numCapitulo'] = $cap->numCapitulo;
            }
        }
        $listaObras = array();
        if(!empty($_COOKIE['notificacao'])){
            $favoritos = $user->favoritos()->get();
            $count = 0;
            foreach($favoritos as $fav){
                $obra = $fav->obra()->first();
                $capitulos = $obra->capitulos()->where('created_at','>=',$fav->created_at)
                    ->orderBy('numCapitulo','desc')
                    ->get();
                $naoLido = false;
                foreach($capitulos as $cap){
                    if(!$user->historicos()->where('capitulo_id',$cap->id)->exists())
                        $naoLido = true;
                }
                if($naoLido)
                    array_push($listaObras, $obra);
                $listaCapitulos = array();
                foreach($capitulos as $cap){
                    if(!$user->historicos()->where('capitulo_id',$cap->id)->exists())
                        array_push($listaCapitulos, $cap);
                }
                if(sizeof($listaObras) && sizeof($listaCapitulos)){
                    $listaObras[$count]->capitulos = $listaCapitulos;
                    $count++;
                }
            }
        }
        return view('leitor.perfil',[
            'obras' => $obras,
            'historicos' => $leituras,
            'notificacao' => $listaObras 
        ]);
    }

    public function nota($id){
        $nota = Avaliacao::where('idObra','=',$id)->avg('nota');
        return number_format($nota,1);
    }

    public function apagarHistorico($id){
        $user = Auth::user();
        if($user){
            
            if($user->historicos()->where('obra_id',$id)->exists()){
                $historico = $user->historicos()->where('obra_id',$id);
                $historico->delete();
            }
        }
        return redirect()->back();
    }
}
