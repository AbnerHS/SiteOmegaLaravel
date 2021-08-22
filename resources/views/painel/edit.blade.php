@extends('painel.layout.style')
@section('title','Editar')
@section('content')
@php
    $table = $item->getTable();
@endphp
<div class="row"></div>
<div class="row">
    <form action="{{route("$table.update",$item->id)}}" method="POST" class="col s12">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="input-field col s12">
                <input id="nome" type="text" class="validate" name="nome" value="{{$item->nome}}">
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
    <div class="row">
        <div class="col s12">
            <form action="{{route("$table.destroy",$item->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn right red darken-2"><i class="material-icons right">delete</i>Excluir</button>
            </form>
        </div>
    </div>
</div>
@endsection