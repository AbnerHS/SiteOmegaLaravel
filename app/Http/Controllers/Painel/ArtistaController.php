<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Artista;
use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
        $this->middleware('check.is.admin')->only(['edit','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Artista::get();
        return view('painel.list', compact('lista'));
    }

    public static function list(){
        $lista = Artista::get();
        return $lista;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $table = (object) [
            'nome' => 'Artista',
            'table' => 'artistas'
        ];
        return view('painel.create', compact('table'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('nome');
        $artista = Artista::create($data);
        return redirect()->route('artistas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function artistasObra($id)
    {
        $artista = Artista::
            join('artista__obras','artistas.id','=','idArtista')
            ->where('idObra','=',$id)
            ->get();
        return $artista;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$item = Artista::find($id))
            return redirect()->back();
        return view('painel.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$artista = Artista::find($id))
            return redirect()->back();
        $data = $request->only('nome');
        $artista->update($data);
        return redirect()->route('artistas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$artista = Artista::find($id))
            return redirect()->back();
        $artista->delete();
        return redirect()->route('artistas.index');
    }
}
