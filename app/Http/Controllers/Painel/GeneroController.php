<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Genero::get();
        return view('painel.list', compact('lista'));
    }

    public static function list(){
        $lista = Genero::get();
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
            'nome' => 'Gênero',
            'table' => 'generos'
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
        $genero = Genero::create($data);
        return redirect()->route('generos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function generosObra($id)
    {
        $genero = Genero::
            join('genero__obras','generos.id','=','idGenero')
            ->where('idObra','=', $id)
            ->get();
        return $genero;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$item = Genero::find($id))
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
        if(!$genero = Genero::find($id))
            return redirect()->back();
        $data = $request->only('nome');
        $genero->update($data);
        return redirect()->route('generos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$genero = Genero::find($id))
            return redirect()->back();
        $genero->delete();
        return redirect()->route('generos.index');
    }
}
