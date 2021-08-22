@extends('painel.layout.style')
@section('title','Nova Scan')
@section('content')
<h4>Perfil</h4>

<div class="row">
    <div class="col s4">
        <img src="{{asset("storage/$scan->logo")}}" class="responsive-img" id="preview">
    </div>  
    <form action="{{'scans.update'}}" method="POST" enctype="multipart/form-data" class="col s8">
        @csrf
        @method("PUT")
        <div class="row">
            <div class="file-field input-field col s12">
                <div class="btn red darken-2">
                    <span>Arquivo</span>
                    <input type="file" name="logo" id="img-input" accept="image/png, image/jpeg" class="tooltipped" data-tooltip="Escolha uma logo em formato quadrado">
                </div>
                <div class="file-path-wrapper">
                    <input id="caminhoImagem" type="text" class="file-path validate" type="text" placeholder="Logo da Scan">
                </div>
            </div>
            <div class="input-field col s12">
                <input id="nome" type="text" class="validate" name="nomeScan" required value="{{$scan->nomeScan}}">
                <label for="nome">Nome da Scan</label>
            </div>
            <div class="input-field col s12">
                <input id="discord" type="text" class="validate" name="discord" value="{{$scan->discord}}">
                <label for="discord">Discord</label>
            </div>
            <div class="input-field col s12">
                <input id="instagram" type="text" class="validate" name="instagram" value="{{$scan->instagram}}">
                <label for="instagram">Instagram</label>
            </div>
            <div class="input-field col s12">
                <input id="facebook" type="text" class="validate" name="facebook" value="{{$scan->facebook}}">
                <label for="facebook">Facebook</label>
            </div>
            <div class="input-field col s12">
                <input id="twitter" type="text" class="validate" name="twitter" value="{{$scan->twitter}}">
                <label for="twitter">Twitter</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <button class="btn waves-effect waves-light green right" type="submit" name="action">Salvar
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
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

    @if(session('erro'))
        @section('script')
            <script>
                M.toast({html: "{{session('erro')}}"});
            </script>
        @endsection
    @endif
</script>
@endsection