@extends('painel.layout.style')
@section('title','Cadastrar Doação')

@section('content')
<h4>Cadastrar Doação</h4>
<div class="row" style="margin-top: 3rem">
    <form action="{{route('doacaos.store')}}" method="POST" class="col s12">
        @csrf
        @method("POST")
        <div class="row">
            <div class="input-field col s12">
                <input type="text" value="{{$usuario->name}}" disabled>
                <label for="">Usuário</label>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{$usuario->id}}">
        <div class="row">
            <div class="input-field col s12">
                <input id="valor" type="number" class="validate" name="valor" required>
                <label for="valor">Valor</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <button class="btn waves-effect waves-light green right" type="submit" name="action">Salvar
                    <i class="material-icons right">send</i>
                </button>
                <a class="btn waves-effect waves-light red darken-2 right" 
                    href="{{URL::previous()}}" style="margin-right:25px">
                    <i class="material-icons right">backspace</i>Cancelar
                </a>
            </div>
        </div>
    </form>
</div>
@endsection