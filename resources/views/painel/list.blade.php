@extends('painel.layout.style')
@section('title','Listagem')
@section('style')
<style>
    a {
        color: black;
    }
</style>
@endsection
@section('content')
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($lista as $item)
        @if($loop->first)
            @php
                $table = $item->getTable();
            @endphp
        @endif
        <tr>
            <td>{{$item->nome}}</td>
            <td><a href="{{route("$table.edit",$item->id)}}"><i class="material-icons">edit</i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light red darken-2 tooltipped" 
        href="{{route("$table.create")}}" data-position="left" data-tooltip="Novo">
      <i class="large material-icons">add</i>
    </a>
</div>
@endsection