@extends('painel.layout.style')
@section('title',$obra->tituloObra)
@section('content')
<h4>Obra</h4>
<div class="row">
    <form action="{{route('obras.update',$obra->id)}}" method="POST" class="col s9" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="file-field input-field col s12">
                <div class="btn red darken-2">
                    <span>Arquivo</span>
                    <input type="file" name="capaObra" id="img-input" accept="image/png, image/jpeg">
                </div>
                <div class="file-path-wrapper">
                    <input id="caminhoImagem" type="text" class="file-path validate" type="text" placeholder="Arquivo de Imagem">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="titulo" type="text" class="validate" name="tituloObra" value="{{$obra->tituloObra}}" required>
                <label for="titulo">Titulo</label>
            </div>
            <div class="input-field col s6">
                <input id="tituloAlt" type="text" class="validate" name="tituloAlternativo" value="{{$obra->tituloAlternativo}}">
                <label for="tituloAlt">Titulo Alternativo</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="tipo" type="text" class="validate" name="tipoObra" value="{{$obra->tipoObra}}" required>
                <label for="tipo">Tipo</label>
            </div>
            <div class="input-field col s6">
                <input id="lancamento" type="text" class="datepicker" name="lancamentoObra" value="{{$obra->lancamentoObra}}" required>
                <label for="lancamento">Data de Lançamento</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select name="status" required>
                    <option value="Em Lançamento">Em Lançamento</option>
                    <option value="Completo">Completo</option>
                    <option value="Dropado">Dropado</option>
                </select>
                <label>Status</label>
            </div>
            <div class="input-field">
                <div class="input-field col s6">
                    <select name="idAutor[]" multiple>
                        <option value="" disabled>Escolha os autores</option>
                        @foreach ($autoresList as $autor)
                            <option class='autorOption' value="{{$autor->id}}">{{$autor->nome}}</option>    
                        @endforeach
                    </select>
                    <label>Autores</label>
                </div>
            </div>
            <div class="input-field">
                <div class="input-field col s6">
                    <select name="idArtista[]" multiple>
                        <option value="" disabled>Escolha os artistas</option>
                        @foreach($artistasList as $artista)
                            <option class='artistaOption' value="{{$artista->id}}">{{$artista->nome}}</option>
                        @endforeach
                    </select>
                    <label>Artistas</label>
                </div>
            </div>
            <div class="input-field">
                <div class="input-field col s6">
                    <select name="idGenero[]" multiple>
                        <option value="" disabled>Escolha os gêneros</option>
                        @foreach ($generosList as $genero)
                            <option class='generoOption' value={{$genero->id}}>{{$genero->nome}}</option>    
                        @endforeach
                    </select>
                    <label>Gêneros</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea name="sinopseObra" id="sinopse" cols="30" rows="10" class="materialize-textarea">{{$obra->sinopseObra}}
                </textarea>
                <label for="sinopse">Sinopse</label>
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
    <div class="col s3">
        <img src='{{asset("storage/$obra->capaObra")}}' id="preview" class="responsive-img">
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $(".datepicker").datepicker();
        $("[value='{{$obra->status}}']").attr("selected",true);
        @foreach($autores as $autor)
            $(".autorOption[value='{{$autor->id}}'").attr("selected",true);
        @endforeach
        @foreach($artistas as $artista)
            $(".artistaOption[value='{{$artista->id}}'").attr("selected",true);
        @endforeach
        @foreach($generos as $genero)
            $(".generoOption[value='{{$genero->id}}'").attr("selected",true);
        @endforeach
        $('select').formSelect();
        var instance = M.Datepicker.getInstance($(".datepicker"));
        instance.options.format = "yyyy-mm-dd";
    });
    function readImage() {
        if (this.files && this.files[0]) {
            var file = new FileReader();
            file.onload = function(e) {
                document.getElementById("preview").src = e.target.result;
            };       
            file.readAsDataURL(this.files[0]);
        }
    }
    document.getElementById("img-input").addEventListener("change", readImage, false);
    @if($errors->any())
        @foreach($errors->all() as $error)
            M.toast({html: '{{$error}}' }, 10000);
        @endforeach
    @endif
</script>
@endsection