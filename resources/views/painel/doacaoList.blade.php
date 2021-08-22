@extends('painel.layout.style')
@section('title','Lista de Doações')

@section('content')
<h5>Doações</h5>
<table>
    <thead>
        <tr>
            <th>Usuário</th>
            <th>Valor</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($doacaos as $doacao)
            <tr>
                <td>
                    {{$doacao->user()->first()->name}}
                </td>
                <td>
                    R${{$doacao->valor}}
                </td>
                <td>
                    {{date_format(date_create($doacao->created_at), 'd/m/Y')}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col s12 center">
        {!!$doacaos->links()!!}
    </div>
</div>
@endsection