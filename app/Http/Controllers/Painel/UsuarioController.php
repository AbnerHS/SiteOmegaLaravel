<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UsuarioController extends Controller
{
    public function index(){
        $usuarios = User::where('tipo_usuario','!=',1)
            ->orderBy('created_at','desc')
            ->paginate();
        return view("painel.usuario",compact("usuarios"));
    }
    
    public function edit($id){
        if(!$usuario = User::find($id))
            return redirect()->back();
        return view('painel.usuarioEdit', compact('usuario'));
    }

    public function update(Request $request, $id){
        $id = $request->id;
        if(!$usuario = User::find($id))
            return redirect()->back();
        if($usuario->tipo_usuario == 2)    
            $tipo = 3;
        else
            $tipo = 2;
        $data = array(
            'tipo_usuario' => $tipo
        );
        $usuario->update($data);
    }

    public function search(Request $request){
        $filters = $request->except('_token');
        $usuario = new User();
        $usuarios = $usuario->search($request->nome);
        return view('painel.usuario',[
            'usuarios' => $usuarios,
            'filters' => $filters
        ]);
    }
}
