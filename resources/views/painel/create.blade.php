@extends('painel.layout.style')
@section('title','Criar')
@section('content')
<h4>{{$table->nome}}</h4>
<div class="row">
    <form action="{{route("$table->table.store")}}" method="POST" class="col s12">
        @csrf
        @method("POST")
        <div class="row">
            <div class="input-field col s12">
                <input id="nome" type="text" class="validate" name="nome" required>
                <label for="nome">Nome</label>
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