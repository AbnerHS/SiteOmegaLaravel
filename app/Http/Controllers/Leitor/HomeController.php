<?php

namespace App\Http\Controllers\Leitor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Painel\ArtistaController;
use App\Http\Controllers\Painel\AutorController;
use App\Http\Controllers\Painel\CapituloController;
use App\Http\Controllers\Painel\GeneroController;
use App\Models\Avaliacao;
use App\Models\Capitulo;
use App\Models\Genero;
use App\Models\Obra;
use App\Models\Pagina;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('check.is.vip')->only(['index','show','showCapitulo','search']);
        $this->middleware('conta.acesso.obra')->only('showCapitulo');
        $this->middleware('leitura.capitulo')->only('showCapitulo');
        $this->middleware('notifica.capitulo')->only(['index','show','showCapitulo','search']);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $obras = Obra::orderBy('data_capitulo','desc')->paginate(12);
        foreach($obras as $obra){
            $obra->capitulos = Capitulo::where('idObra','=',$obra->id)->orderBy('numCapitulo','desc')->limit(2)->get();
            $obra->nota = $this->nota($obra->id);
        }
        $destaques = Obra::orderBy('views','desc')->limit(3)->get();
        return view("home", compact(['destaques','obras']));
    }
    public function show($id)
    {
        if(!$obra = Obra::find($id))
            return redirect()->back();
        $obra['views'] = $this->formatar($obra['views']);
        $autor = AutorController::autoresObra($id);
        $artista = ArtistaController::artistasObra($id);
        $genero = GeneroController::generosObra($id);
        $capitulo = CapituloController::capitulosObra($id);
        $nota = $this->nota($id);
        $capituloAtual = NULL;
        if(Auth::user()){
            $user = Auth::user();
            if($user->historicos()->where('obra_id',$obra->id)->exists()){
                $historico = $user->historicos()->where('obra_id',$obra->id)->orderBy('updated_at','desc')->first();
                $capituloAtual = $historico->capitulo()->first()->numCapitulo;
                $capituloAtual = $capitulo->where('numCapitulo','>',$capituloAtual)->min('numCapitulo');
                if($capituloAtual > $capitulo->first()->numCapitulo)
                    $capituloAtual = NULL;
            }
        }
        return view('leitor.obra', [
            'obra' => $obra,
            'autores' => $autor,
            'artistas' => $artista,
            'generos' => $genero,
            'capitulos' => $capitulo,
            'nota' => $nota,
            'atual' => $capituloAtual
        ]);
    }

    public function showCapitulo($obra,$capitulo){
        if(!Obra::find($obra) || !$cap = Capitulo::where('numCapitulo','=',$capitulo)
                                                    ->where('idObra','=',$obra)
                                                    ->first())
            return redirect()->back();
        $scan = Obra::find($obra);
        $pub = new DateTime($cap->created_at);
        $pub = $pub->format('Y-m-d H:i:s');
        $atual = date('Y-m-d H:i:s');
        $dif = strtotime($atual) - strtotime($pub);
        $horas = (floor($dif/(60*60)));
        $vip = $_COOKIE['vip'] ?? false;
        if($horas < 2 && !$vip && $scan->scan_id == NULL){
            return redirect()->back()->with('erro','Disponível para doadores!');
        }
        $paginas = Pagina::where('idCapitulo','=',$cap->id)
            ->orderBy('numeroPagina','asc')
            ->get();
        $capitulos = Capitulo::where('idObra','=',$obra)->orderBy('numCapitulo','desc')->get();
        $anterior = $capitulos->where('numCapitulo','<',$cap->numCapitulo)->max('numCapitulo');
        $proximo = $capitulos->where('numCapitulo','>',$cap->numCapitulo)->min('numCapitulo');
        $first = $capitulos->last()->numCapitulo == $capitulo;
        $last = $capitulos->first()->numCapitulo == $capitulo;
        $nome = Obra::find($obra)->tituloObra;
        return view('leitor.pagina',[
            'obra' => $obra,
            'capitulos' => $capitulos,
            'num' => $capitulo,
            'nome' => $nome,
            'ultimo' => $last,
            'primeiro' => $first,
            'proximo' => str_replace('.0', '', $proximo),
            'anterior' => str_replace('.0', '', $anterior),
            'paginas' => $paginas
        ]);
    }

    public function search(Request $request){
        $filtro = $request->filtros;
        $order = $request->order;
        $gen = $request->genero;
        $obra = new Obra();
        $obras = $obra->search($filtro,$order,$gen);
        foreach($obras as $obra){
            $obra->capitulos = Capitulo::where('idObra','=',$obra->id)->orderBy('numCapitulo','desc')->limit(2)->get();
            $obra->nota = $this->nota($obra->id);
        }
        $generos = Genero::orderBy('nome')->get();
        foreach($generos as $genero){
            $genero->obras = Obra::join('genero__obras','idObra','=','id')
                                    ->where('idGenero','=',$genero->id)->get()->count();
        }
        return view('leitor.projetos', [
            'obras' => $obras,
            'generos' => $generos,
            'gen' => $gen,
            'linhas' => $obras->count(),
            'filtros' => $filtro
        ]);
    }

    public function searchField(Request $request){
        $filtro = $request->filtro;
        $user = NULL;
        if(Auth::user())
            $user = Auth::user();
        $obra = new Obra();
        $obras = $obra->searchField($filtro);
        foreach($obras as $obra){
            $obra->genero = Genero::join('genero__obras','id','=','idGenero')
                ->where('idObra','=',$obra->id)->limit(1)->get();
            $obra->favorito = false;
            if($user){
                if($user->favoritos()->where('obra_id',$obra->id)->exists())
                    $obra->favorito = true;
            }
        }
        return $obras;
    }

    public function nota($id){
        $nota = Avaliacao::where('idObra','=',$id)->avg('nota');
        return number_format($nota,1);
    }

    public function avaliar(Request $request, $id){
        $data = [
            'nota' => $request->nota,
            'idObra' => $id
        ];
        $avaliacao = Avaliacao::create($data);
        $nota = Avaliacao::where('idObra','=',$id)->avg('nota');
        return number_format($nota,1);
    }

    public function favoritar(Request $request, $id){
        if($user = Auth::user()){
            if(!$user->favoritos()->where('obra_id',$id)->exists()){
                $user->favoritos()->create(['obra_id' => $id]);
            } else {
                $user->favoritos()->where('obra_id',$id)->delete();
            }
        } else {
            return redirect()->back()->with('erro','Você precisa estar logado!');
        }
        return redirect()->back();
    }

    public function verificarNotificacao(){
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
        return $notificacao;
    }

    public function formatar( $n, $precision = 1 ) {
        if ($n < 1000) {
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        }
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }
}
