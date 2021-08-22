@extends('layouts.style')
@section('title','Perfil')
@section('content')
    @if($_COOKIE['vip']??false)
    @else
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                style="display:inline-block;width:95%; height:90px; margin-left:2.5%"
                data-ad-client="ca-pub-4636385704936476"
                data-ad-slot="5657293816"></ins>
        <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endif
    <blockquote><h5>Bem vindo, {{Auth::user()->name}}</h5></blockquote>
    <ul class="collapsible popout">
        @empty($notificacao)
        @else
        <li class="active">
            <div class="collapsible-header">
                <h5 class="red-text text-darken-4"><i class="material-icons left" style="line-height: 2rem">notifications</i>Atualizações</h5>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    @foreach ($notificacao as $projeto)
                        <div class="col s12 l6">
                            <div class="card horizontal">
                                <div class="card-image" style="height: 180px; overflow: hidden;">
                                    <img src="{{asset("storage/$projeto->capaObra")}}" width="120px" style="max-height:180px">
                                </div>
                                <div class="card-stacked" style="max-height: 180px">
                                    <div class="card-content" style="overflow: auto; padding:1.2rem">
                                        <p style="font-weight:500">{{$projeto->tituloObra}}</p>
                                        @foreach ($projeto->capitulos as $cap)
                                        <a href="{{route('capitulo',[$projeto->id,str_replace('.0', '', $cap->numCapitulo)])}}" style="color:black">
                                            <p>
                                                <div class="chip" style="font-weight: unset">
                                                    <span class="black-text">Cap {{str_replace('.0', '', $cap->numCapitulo)}}</span>
                                                </div>
                                                @php
                                                    $date = new DateTime($cap->created_at);
                                                    $date = $date->format('d/m/Y');
                                                @endphp
                                                <span style="font-size:12px; line-height:2.25rem;">
                                                    {{$date}}
                                                </span>
                                            </p>
                                        </a> 
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </li>
        @endempty
        <li>
            <div class="collapsible-header">
                <h5><i class="material-icons left" style="line-height: 2rem">favorite</i>Favoritos</h5>
            </div>
            <div class="collapsible-body">
                <div class="row">
                    @if($obras)
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Projeto</th>
                                <th class="truncate">Atualizado em</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obras as $obra)
                                <tr>
                                    <td>
                                        <div class="col s3">
                                            <a href="{{route('leitor.show',$obra->id)}}"><img src="{{asset("storage/$obra->capaObra")}}" width="100px"></a>
                                        </div>
                                        <div class="col s4 hide-on-small-only">
                                            <a href="{{route('leitor.show',$obra->id)}}" style="font-weight: 500" class="black-text">{{$obra->tituloObra}}</a>
                                            @foreach ($obra->capitulos as $cap)
                                                <a href="{{route('capitulo',[$obra->id,str_replace('.0', '', $cap->numCapitulo)])}}" style="color:black">
                                                    <p>
                                                        <div class="chip" style="font-weight: unset">
                                                            <span class="black-text">Cap {{str_replace('.0', '', $cap->numCapitulo)}}</span>
                                                        </div>
                                                        @php
                                                            $date = new DateTime($cap->created_at);
                                                            $date = $date->format('d/m/Y');
                                                            $pub = date_format($cap->created_at, 'Y-m-d');
                                                            $atual = date('Y-m-d');
                                                            $dif = strtotime($atual) - strtotime($pub);
                                                            $dif = floor($dif/(60*60*24));
                                                        @endphp
                                                        <span style="font-size:12px; line-height:2.25rem;">
                                                            @if($dif > 3)
                                                                {{$date}}
                                                            @elseif($dif <= 1)
                                                                <span class="badge red darken-4 pulse white-text" style="font-size:0.8rem;margin-top:0.45rem">NEW</span>
                                                            @else
                                                                {{$dif}} dias atrás
                                                            @endif
                                                        </span>
                                                    </p>
                                                </a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $date = new DateTime($obra->data_capitulo);
                                            $date = $date->format('d/m/Y');
                                        @endphp
                                        {{$date}}
                                    </td>
                                    <td>
                                        <a href="{{route('favoritar',$obra->id)}}"><i class="material-icons grey-text">delete</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <h6>Você ainda não possui favoritos!</h6>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <div class="collapsible-header">
                <h5><i class="material-icons left" style="line-height: 2rem">history</i>Histórico</h5>
            </div>
            <div class="collapsible-body">
                @if($historicos)
                <div class="row">
                    @foreach ($historicos as $projeto)
                    <div class="col s12 l4">
                        <div class="card horizontal" style="height: 150px">
                            <a href="{{route('perfil.apagar',$projeto->id)}}" style="position: absolute; right:0; z-index:9"><i class="material-icons grey-text">close</i></a>
                            <div class="card-image" style="height: 150px; overflow: hidden;">
                                <img src="{{asset("storage/$projeto->capaObra")}}" width="100px" style="max-height: 150px">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                    <p style="font-weight:500">{{$projeto->tituloObra}}</p>
                                    <p class="grey-text text-darken-3">Cap {{str_replace('.0', '', $projeto->numCapitulo)}}</p>
                                    @php
                                        $date = new DateTime($projeto->data);
                                        $date = $date->format('d/m/Y');
                                        $leitura = date_format($projeto->data, 'Y-m-d H:i');
                                        $atual = date('Y-m-d H:i');
                                        $min = (strtotime($atual) - strtotime($leitura))/60;
                                        $hora = 0;
                                        $dia = 0;
                                        $valor = $min;
                                        $tempo = "minutos";
                                        if($min >= 60){
                                            $hora = ceil($min/60);
                                            $valor = $hora;
                                            $tempo = "horas";
                                        }
                                        if($hora >= 24){
                                            $dia = ceil($hora/24);
                                            $valor = $dia;
                                            $tempo = "dias";
                                        }
                                    @endphp
                                    <p class="grey-text text-darken-2">{{$valor." ".$tempo}} atrás</p>
                                </div>
                            </div>
                        </div>
                    </div>
                             
                    @endforeach
                </div>
                @else
                    <h6>Você ainda não leu nada!</h6>
                @endif
            </div>
        </li>
        <li>
            <div class="collapsible-header">
                <h5><i class="material-icons left" style="line-height: 2rem">settings</i>Configurações</h5>
            </div>
            <div class="collapsible-body">
                <h5>Modo de Leitura</h6>
                <div class="switch">
                    <label style="font-size: 1.2rem">
                        Infinito
                        <input type="checkbox" id="tipo">
                        <span class="lever"></span>
                        Por Página
                    </label>
                </div>
                <h5>Tema</h6>
                <div class="switch">
                    <label style="font-size: 1.2rem">
                        Escuro
                        <input type="checkbox" id="modo">
                        <span class="lever"></span>
                        Claro
                    </label>
                </div>
            </div>
        </li>
    </ul>    
@endsection

@section('script')
<script src="{{asset('js/cookie.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.collapsible').collapsible();
        var modo = getCookie('modo');
        if(modo.length > 0){
            if(modo == 'light'){
                $("#modo")[0].checked = true;
            }
        }
        var tipo = getCookie('tipo');
        if(tipo.length > 0){
            if(tipo == 'page'){
                $("#tipo")[0].checked = true;
            }
        }
        $("#tipo").change(function(){
            if(this.checked)
                setCookie('tipo','page',365);
            else
                setCookie('tipo','list',365);
        });
        $("#modo").change(function(){
            if(this.checked)
                setCookie('modo','light',365);
            else
                setCookie('modo','dark',365);
        });
        
    });
</script>
@endsection