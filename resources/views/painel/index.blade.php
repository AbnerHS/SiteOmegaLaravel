@extends('painel.layout.style')
@section('title','Obras')
@section('content')
<div class="row">
    <div class="col s12"><h5>Obras</h5></div>
    @foreach ($obras as $obra)
    <div class="col l2 m4 s6">
        <div class="card waves-effect waves-light hoverable" style="display:block">
            <a href="{{route('obras.show', $obra->id)}}">
            <div class="card-image" style="height: 150px; overflow:hidden">
                <table style="height: 150px">
                    <tr style="border:none">
                        <td><img src="{{asset("storage/$obra->capaObra")}}" style="max-height: auto"></td>
                    </tr>
                </table>
            </div>
            <div class="card-stacked">
                <div class="card-content" style="padding: 16px">
                    <p style="color:black;" class="truncate">{{$obra->tituloObra}}</p>
                </div>
            </div>
            </a>
        </div>
    </div>
    @endforeach
</div>

<div class="fixed-action-btn">
    <a class="btn-floating pulse btn-large waves-effect waves-light red darken-2 tooltipped"
        href="{{route('obras.create')}}" data-position="left" data-tooltip="Nova Obra">
      <i class="large material-icons">add</i>
    </a>
</div>
@endsection

@if(session('erro'))
    @section('script')
        <script>
            M.toast({html: "{{session('erro')}}"});
        </script>
    @endsection
@endif
