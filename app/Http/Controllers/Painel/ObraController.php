<?php

namespace App\Http\Controllers\Painel;

use App\Models\Obra;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateObra;
use App\Models\Artista_Obra;
use App\Models\Autor_Obra;
use App\Models\Capitulo;
use App\Models\Genero_Obra;
use App\Models\Pagina;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ObraController extends Controller
{

    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
        $this->middleware('check.is.admin')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->tipo_usuario == 2){
            if($scan = Auth::user()->scan)
                $obras = $scan->obra;
            else
                return redirect()->route('scans.show','home');
            return view('painel.index', compact("obras"));
        }
        $obras = Obra::orderBy('created_at','desc')->orderBy('updated_at','desc')->get();
        return view('painel.index', compact("obras"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $autores = AutorController::list();
        $artistas = ArtistaController::list();
        $generos = GeneroController::list();
        return view('painel.obraCreate', [
            'autoresList' => $autores,
            'artistasList' => $artistas,
            'generosList' => $generos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(StoreUpdateObra $request)
    {
        $data = $request->except(['_token', '_method','action','capaObra']);
        if($request->hasFile('capaObra') && $request->capaObra->isValid()){
            $imagePath = $request->capaObra->store('obras');
            $data['capaObra'] = $imagePath;
        }
        if($scan = Auth::user()->scan)
            $obra = $scan->obra()->create($data);
        else
            $obra = Obra::create($data);
        foreach($request->idAutor as $autor){
            $autorObra = array(
                'idAutor' => $autor,
                'idObra' => $obra->id
            );
            Autor_Obra::create($autorObra);
        }
        foreach($request->idGenero as $genero){
            $generoObra = array(
                'idGenero' => $genero,
                'idObra' => $obra->id
            );
            Genero_Obra::create($generoObra);
        }
        foreach($request->idArtista as $artista){
            $artistaObra = array(
                'idArtista' => $artista,
                'idObra' => $obra->id
            );
            Artista_Obra::create($artistaObra);
        }
        return redirect()->route('obras.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->tipo_usuario == 2){
            $scan = Auth::user()->scan;
            if(!$obra = $scan->obra->find($id))
                return redirect()->back();
        } else {
            if(!$obra = Obra::find($id))
                return redirect()->back();
        }
        $autor = AutorController::autoresObra($id);
        $artista = ArtistaController::artistasObra($id);
        $genero = GeneroController::generosObra($id);
        $capitulo = CapituloController::capitulosObra($id);
        return view('painel.obraShow', [
            'obra' => $obra,
            'autores' => $autor,
            'artistas' => $artista,
            'generos' => $genero,
            'capitulos' => $capitulo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$obra = Obra::find($id))
            return redirect()->back();
        $autores = AutorController::list();
        $artistas = ArtistaController::list();
        $generos = GeneroController::list();
        $autor = AutorController::autoresObra($id);
        $artista = ArtistaController::artistasObra($id);
        $genero = GeneroController::generosObra($id);
        return view('painel.obraEdit', [
            'obra' => $obra,
            'autoresList' => $autores,
            'artistasList' => $artistas,
            'generosList' => $generos,
            'autores' => $autor,
            'artistas' => $artista,
            'generos' => $genero
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateObra $request, $id)
    {
        if(!$obra = Obra::find($id))
            return redirect()->back();
        $data = $request->only('tituloObra','tituloAlternativo','tipoObra','lancamentoObra',
                                'sinopseObra','status');
        if($request->hasFile('capaObra') && $request->capaObra->isValid()){
            if($obra->capaObra && Storage::exists($obra->capaObra)){
                Storage::delete($obra->capaObra);
            }
            $imagePath = $request->capaObra->store('obras');
            $data['capaObra'] = $imagePath;
        }
        $obra->update($data);
        Autor_Obra::where('idObra','=',$obra->id)->delete();
        foreach($request->idAutor as $autor){
            $autorObra = array(
                'idAutor' => $autor,
                'idObra' => $obra->id
            );
            Autor_Obra::create($autorObra);
        }
        Artista_Obra::where('idObra','=',$obra->id)->delete();
        foreach($request->idArtista as $artista){
            $artistaObra = array(
                'idArtista' => $artista,
                'idObra' => $obra->id
            );
            Artista_Obra::create($artistaObra);
        }
        Genero_Obra::where('idObra','=',$obra->id)->delete();
        foreach($request->idGenero as $genero){
            $generoObra = array(
                'idGenero' => $genero,
                'idObra' => $obra->id
            );
            Genero_Obra::create($generoObra);
        }
        return redirect()->route('obras.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$obra = Obra::find($id))
            return redirect()->back();
        if($obra->capaObra && Storage::exists($obra->capaObra)){
            Storage::delete($obra->capaObra);
        }
        if($capitulos = Capitulo::where('idObra','=',$id)->get()){
            foreach($capitulos as $capitulo){
                if($paginas = Pagina::where('idCapitulo','=',$capitulo->id)->get()){
                    foreach($paginas as $pagina){
                        if(Storage::exists($pagina->imagemPagina))
                            Storage::delete($pagina->imagemPagina);
                    }
                }
            }
        }
        $obra->delete();
        return redirect()->route('obras.index');
    }

    public function search(Request $request){
        $filters = $request->except("_token");
        $obra = new Obra();
        $obras = $obra->search($request->titulo);
        return view('painel.obras',[
            'obras' => $obras,
            'filters' => $filters
        ]);
    }
}
