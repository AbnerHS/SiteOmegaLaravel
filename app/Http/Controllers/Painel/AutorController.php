<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
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
        $lista = Autor::orderBy("nome","asc")->get();
        return view('painel.list', compact("lista"));
    }

    public static function list(){
        $lista = Autor::get();
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
            'nome' => 'Autor',
            'table' => 'autors'
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
        $data = $request->only("nome");
        $autor = Autor::create($data);
        return redirect()->route("autors.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function autoresObra($id)
    {
        $autor = Autor::
            join('autor__obras','autors.id','=','idAutor')
            ->where('idObra','=',$id)
            ->get();
        return $autor;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$item = Autor::find($id))
            return redirect()->back();
        return view('painel.edit', compact("item"));
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
        if(!$autor = Autor::find($id))
            return redirect()->back();
        $data = $request->only('nome');
        $autor->update($data);
        return redirect()->route('autors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$autor = Autor::find($id))
            return redirect()->back();
        $autor->delete();
        return redirect()->route('autors.index');
    }
}
