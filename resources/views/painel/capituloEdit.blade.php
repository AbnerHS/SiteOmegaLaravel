@extends('painel.layout.style')
@section('title','Editar Capítulo')
@section('content')
<h4>Capítulo {{str_replace('.0', '', $capitulo->numCapitulo)}}</h4>
<div class="row">
    @php
        $params = array(
            'id' => $id,
            'capitulo' => $capitulo->id
        );
    @endphp
    <form action="{{route('capitulos.update',$params)}}" method="POST" class="col s12" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="file-field input-field">
                <div class="btn red darken-2">
                    <span>Arquivos</span>
                    <input type="file" name="imagem[]" accept="image/png, image/jpeg" required multiple>
                </div>
                <div class="file-path-wrapper">
                    <input type="text" class="file-path validate" placeholder="Arquivos de imagem">
                </div>
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
<div class="row">
    @foreach ($pagina as $pag)
        <img src="{{asset("storage/$pag->imagemPagina")}}" style="vertical-align:middle">
    @endforeach
</div>
@endsection