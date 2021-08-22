@extends('painel.layout.style')
@section('title', $obra->tituloObra)
@section('style')
<style>
    a {
        color: black;
    }
</style>
@endsection
@section('content')
<div class="row"></div>
<div class="row">
  <div class="col s8">
    <h2>{{$obra->tituloObra}}</h2>
    <h4>Sinopse</h4>
    <blockquote>
      {{$obra->sinopseObra}}
    </blockquote>
    <h4>Informações</h4>
    <blockquote>
      <p><span style="font-weight:bold">Tipo:</span> {{$obra->tipoObra}}</p>
      <p><span style="font-weight:bold">Lançamento:</span> {{date_format(date_create($obra->lancamentoObra), 'd/m/Y')}}</p>
      <p><span style="font-weight:bold">Status:</span> {{$obra->status}}</p>
      <p><span style="font-weight:bold">Autores:</span> 
        @foreach ($autores as $autor)
          {{$autor->nome}}@if(!$loop->last),@endif
        @endforeach
      </p>
      <p><span style="font-weight:bold">Artistas:</span>
        @foreach ($artistas as $artista)
          {{$artista->nome}}@if(!$loop->last),@endif
        @endforeach
      </p>
      <p><span style="font-weight:bold">Gêneros:</span>
        @foreach ($generos as $genero)
          {{$genero->nome}}@if(!$loop->last),@endif
        @endforeach
      </p>
  </div>
  <div class="col s4">
    <img src="{{asset("storage/$obra->capaObra")}}" class="responsive-img">
  </div>
</div>
@isset($obra->scan)
<div class="row">
  <h4>Scan Responsável</h4>
  <blockquote><p style="font-weight: bold">{{$obra->scan->nomeScan}}</p></blockquote>
</div>
@endisset
<div class="row">
  <h4>Capítulos</h4>
  <div class="col s8">
    <blockquote>
      @foreach ($capitulos as $capitulo)
        <p style="font-weight: bold; padding-bottom:8px">
          Capitulo {{str_replace('.0', '', $capitulo->numCapitulo)}}
          @php 
          $params = array(
            'id' => $obra->id,
            'capitulo' => $capitulo->id
          ); 
          @endphp
          <a class="right" href="{{route('capitulos.edit',$params)}}"><i class="material-icons">edit</i></a>
        </p>
      @endforeach
    </blockquote>
  </div>
</div>

<div id="modalDelete" class="modal">
  <div class="modal-content">
    <h4>Deseja realmente excluir {{$obra->tituloObra}}?</h4>
  </div>
  <div class="modal-footer">
    <form action="{{route('obras.destroy',$obra->id)}}" method="post">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn red darken-2 right">Excluir</button>
      <a href="#!" class="modal-close waves-effect waves-green btn-flat btn right" style="margin-right:25px">Cancelar</a>
    </form>
  </div>
</div>

<div id="modalDeleteCapitulo" class="modal">
  <div class="modal-content">
    <h4>Deseja realmente excluir o último capítulo?</h4>
  </div>
  <div class="modal-footer">
    <form action="{{route('capitulos.destroy',[$obra->id,0])}}" method="post">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn red darken-2 right">Excluir</button>
      <a href="#!" class="modal-close waves-effect waves-green btn-flat btn right" style="margin-right: 25px">Cancelar</a>
    </form>
  </div>
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light red darken-2">
      <i class="large material-icons">menu</i>
    </a>
    <ul>
      <li>
          <a class="btn-floating waves-effect waves-light red darken-2 tooltipped" 
            data-position="left" data-tooltip="Editar Obra" href="{{route('obras.edit',$obra->id)}}">
            <i class="material-icons">mode_edit</i>
          </a>
        </a>
      </li>
      <li>
        <a class="btn-floating waves-effect waves-light red darken-2 modal-trigger tooltipped" 
          data-position="left" data-tooltip="Excluir Obra" href="#modalDelete">
          <i class="material-icons">delete</i>
        </a>
      </li>
      <li>
        <a class="btn-floating waves-effect waves-light red darken-2 tooltipped" 
          data-position="left" data-tooltip="Novo Capítulo"  href="{{route('capitulos.create',$obra->id)}}">
          <i class="material-icons">add</i>
        </a>
      </li>
      <li>
        <a class="btn-floating waves-effect waves-light red darken-2 modal-trigger tooltipped" 
          data-position="left" data-tooltip="Excluir Último Capítulo" href="#modalDeleteCapitulo">
          <i class="material-icons">remove</i>
        </a>
      </li>
    </ul>
</div>
@endsection

@section('script')
<script>
  $(document).ready(function(){
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems, {
      direction: 'top',
      hoverEnabled: false
    });
    $('.modal').modal();
  });
  @if(session('erro'))
    @section('script')
        <script>
            M.toast({html: "{{session('erro')}}"});
        </script>
    @endsection
  @endif
</script>
@endsection