@extends('painel.layout.style')
@section('title','Novo Capítulo')
@section('content')
<h4>Cadastrar Capítulo(s)</h4>
<div class="row">
<form action="{{route('capitulos.store',$id)}}" method="POST" class="col s12" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="row">
        <div class="file-field input-field">
            <div class="btn red darken-2">
                <span>Arquivos</span>
                <input type="file" name="imagem[]" accept="application/zip,application/x-zip,application/x-zip-compressed,application/octet-stream" required multiple>
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
    <p class="grey-text text-darken-3 flow-text">Para cadastrar um ou mais capítulos, envie em um arquivo .ZIP as pastas enumeradas com os números dos capítulos e com as imagens enumueradas com os números das páginas.</p>
    <p class="grey-text text-darken-3 flow-text">Por Exemplo:</p>
    <img src="{{asset('exemplo.jpg')}}" class="responsive-img">
</div>
@endsection

@section('script')
    <script>
        @if(session('erro'))
            @section('script')
                <script>
                    M.toast({html: "{{session('erro')}}"});
                </script>
            @endsection
        @endif
    </script>
@endsection