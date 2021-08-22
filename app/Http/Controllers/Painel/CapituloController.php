<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Capitulo;
use App\Models\Obra;
use App\Models\Pagina;
use Directory;
use Extractor;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CapituloController extends Controller
{
    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public static function capitulosObra($id){
        $capitulos = Capitulo::where('idObra','=',$id)
            ->orderBy('numCapitulo','desc')
            ->get();
        return $capitulos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if($atual = Capitulo::where('idObra','=',$id)->latest('created_at')->first())
            $num = $atual->numCapitulo+1;
        else
            $num = 1;
        return view('painel.capituloCreate',compact('id','num'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {   
        if(Storage::exists('tmp'))
            Storage::deleteDirectory('tmp');
        $file = $request->imagem[0]->store('tmp');
        $zip = new ZipArchive();
        //$path = public_path('storage\\'.str_replace('/','\\',$file));
        $path = public_path('storage/'.$file);
        if($zip->open($path, ZipArchive::FL_COMPRESSED)){
            $zip->extractTo(public_path('storage/tmp'));
            $zip->close();
            Storage::delete($file);
        }
        $capitulo = null;
        $arquivos = Storage::allFiles('tmp');
        foreach($arquivos as $pasta){
            $imagem = explode("/", $pasta);
            $pagina = $imagem[2];
            $pagina = explode(".",$pagina)[0];
            if(!is_numeric($pagina) || !is_numeric($imagem[1])){
                return redirect()->back()->with('erro','Arquivo(s) com nome inválido!');
            }
        }
        foreach($arquivos as $pasta){
            $imagem = explode("/",$pasta);
            if($imagem[1] != $capitulo){
                $capitulo = $imagem[1];
                $dadosCapitulo = array(
                    'numCapitulo' => $capitulo,
                    'idObra' => $id
                );
                $novoCapitulo = Capitulo::create($dadosCapitulo);
            }
            $pagina = explode(".",$imagem[2])[0];
            $extensao = explode(".",$imagem[2])[1];
            $hashImagem = sha1($pagina.time()).'.'.$extensao;
            rename(public_path('storage/tmp/'.$novoCapitulo->numCapitulo.'/'.$imagem[2]),
                'storage/tmp/'.$novoCapitulo->numCapitulo.'/'.$hashImagem);
            $imagemPagina = $id.'_'.$novoCapitulo->numCapitulo.'/'.$hashImagem;
            $dadosPagina = array(
                'numeroPagina' => $pagina,
                'imagemPagina' => $imagemPagina,
                'idCapitulo' => $novoCapitulo->id  
            );
            $pagina = Pagina::create($dadosPagina);
        }
        $capitulo = null;
        foreach($arquivos as $pasta){
            $imagem = explode("/",$pasta);
            if($imagem[1] != $capitulo){
                $capitulo = $imagem[1];
                rename(public_path('storage/tmp/'.$imagem[1]), public_path('storage/'.$id.'_'.$imagem[1]));
            }
        }
        return redirect()->route('obras.show',$id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$idCapitulo)
    {
        if(!$capitulo = Capitulo::find($idCapitulo))
            return redirect()->back();
        $pagina = Pagina::where('idCapitulo','=',$idCapitulo)->get();
        return view('painel.capituloEdit',compact('capitulo','pagina','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$capitulo)
    {
        if(!$capitulo = Capitulo::find($capitulo))
            return redirect()->back();
        if($paginas = Pagina::where('idCapitulo','=',$capitulo->id)->get()){
            foreach($paginas as $pagina){
                if(Storage::exists($pagina->imagemPagina))
                    Storage::delete($pagina->imagemPagina);
            }
            Pagina::where('idCapitulo','=',$capitulo->id)->delete();
            foreach($request->imagem as $imagem){
                if($imagem->isValid()){
                    $imagePath = $imagem->store($id.'_'.$capitulo->numCapitulo);
                    $arquivo = $imagem->getClientOriginalName();
                    $numPagina = pathinfo($arquivo, PATHINFO_FILENAME);
                    $dadosPagina = array(
                        'numeroPagina' => $numPagina,
                        'imagemPagina' => $imagePath,
                        'idCapitulo' => $capitulo->id
                    );
                    $pagina = Pagina::create($dadosPagina);
                }
            }
        }
        return redirect()->route('obras.show',$id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $capitulo)
    {
        if(!$capitulo = Capitulo::where('idObra','=',$id)->orderBy('numCapitulo','desc')->first())
            return redirect()->back()->with('erro','Não existe um capítulo!');

        if($paginas = Pagina::where('idCapitulo','=',$capitulo->id)->get()){
            foreach($paginas as $pagina){
                if(Storage::exists($pagina->imagemPagina))
                    Storage::delete($pagina->imagemPagina);
            }
            Storage::deleteDirectory($id.'_'.$capitulo->numCapitulo);
        }
        $capitulo->delete();
        return redirect()->route('obras.show',$id);
    }
}
