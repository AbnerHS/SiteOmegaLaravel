@extends('painel.layout.style')
@section('title','Listagem')
@section('style')
<style>
    a {
        color: black;
    }
    .switch label input[type=checkbox]:checked + .lever:after{
        background-color: #b71c1c;
    }
    .switch label input[type=checkbox]:checked + .lever{
        background-color: #f44336;
    }
</style>
@endsection
@section('content')
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($usuarios as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <div class="switch">
                    <label class="black-text">
                        Leitor
                        <input id="{{$user->id}}" type="checkbox" {{$user->tipo_usuario == 3 ? '':'checked'}}>
                        <span class="lever"></span>
                        Uploader
                    </label>
                </div>
            </td>
            <td>
                <a href="{{route("doacaos.show",$user->id)}}" class="tooltipped btn red darken-4 waves-effect waves-light" 
                    data-position="top" data-tooltip="Cadastrar Doação">
                    <i class="material-icons">attach_money</i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col s12 center">
        {!!$usuarios->links()!!}
    </div>
</div>
@csrf
@endsection

@section('script')
<script>
    $("input").change(function(e){
        var id = $(this).attr('id');
        $.ajax({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'PUT',
            url: "{{route('usuarios.update',0)}}",
            data: 'id='+id
        });
    });
</script>
@endsection