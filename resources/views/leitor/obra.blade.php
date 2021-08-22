@extends('layouts.style')
@section('title',$obra->tituloObra)
@section('style')
    <style>
        .row .col p{
            margin: 0.75rem 0px;
        }
        *{
            margin: 0;
            padding: 0;
        }
        .rate {
            float: left;
            height: 46px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }

/* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */
    </style>
@endsection
@section('content')
    @if($_COOKIE['vip']??false)
    @else
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-4636385704936476"
                    data-ad-slot="7509168206"
                    data-ad-format="auto"
                    data-full-width-responsive="false"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endif
    <blockquote><h5>{{$obra->tituloObra}}</h5></blockquote>
    <div class="row">
        <div class="col l3 m4 s12" style="margin-bottom:20px">
            <img src="{{asset("storage/$obra->capaObra")}}" class="materialboxed responsive-img"
                style="border-radius: 8px 20px; border: solid 2px #b71c1c">
        </div>
        <div id="containerObra" class="col offset-m1 offset-l1 l8 m6 s12 z-depth-4" style="border-radius: 20px 8px; border: solid 2px #b71c1c">
            <div class="row" style="margin-bottom:0px">
                <div class="rate" style="margin-left: 1rem">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text"><i class="material-icons">grade</i></label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text"><i class="material-icons">grade</i></label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text"><i class="material-icons">grade</i></label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text"><i class="material-icons">grade</i></label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text"><i class="material-icons">grade</i></label>
                </div> 
            </div>
            <div class="row">
                <div class="col s3 m6 l2">
                    <p><span class="bold">Nota</span></p>
                    <p><span class="bold">Views</span></p>
                    <p><span class="bold">Autor(s)</span></p>
                    <p><span class="bold">Artista(s)</span></p>
                    <p><span class="bold">Gênero(s)</span></p>
                    <p><span class="bold">Tipo</span></p>
                </div>
                <div class="col s3 m6 l4">
                    <p id="nota">{{$nota}} / 5</p>
                    <p>{{$obra->views}}</p>
                    <p class="truncate">
                        @foreach ($autores as $autor)
                            {{$autor->nome}}@if(!$loop->last),@endif
                        @endforeach
                    </p>
                    <p class="truncate">
                        @foreach ($artistas as $artista)
                            {{$artista->nome}}@if(!$loop->last),@endif
                        @endforeach
                    </p>
                    <p class="truncate">
                        @foreach ($generos as $genero)
                            {{$genero->nome}}@if(!$loop->last),@endif
                        @endforeach
                    </p>
                    <p>{{$obra->tipoObra}}</p>
                </div>
                <div class="col s3 m6 l2">
                    <p><span style="font-weight: bold" class="truncate">Lançado em</span></p>
                    <p><span style="font-weight: bold">Status</span></p>
                </div>
                <div class="col s3 m6 l4">
                    @php
                        $date = new DateTime($obra->lancamentoObra);
                        $date = $date->format('d/m/Y');
                    @endphp
                    <p class="truncate">{{$date}}</p>
                    <p class="truncate">{{$obra->status}}</p>
                </div>
                <div class="col l6">
                    <p class="center">
                        @php
                            $favoritada = false;
                            if($user = Auth::user()){
                                if($user->favoritos()->where('obra_id',$obra->id)->exists())
                                    $favoritada = true;
                                else
                                    $favoritada = false;
                            }
                        @endphp
                        <a href="{{route('favoritar',$obra->id)}}" class="tooltipped" data-position="right" data-tooltip="{{$favoritada ? 'Remover dos favoritos':'Adicionar aos favoritos'}}">
                            <i class="material-icons {{$favoritada ? 'text-darken-4 red':'grey'}}-text " style="font-size:2.5rem">bookmark</i>
                        </a>
                        <br>
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    @php
                        if(!empty($capitulos->last())){
                            $primeiro = $capitulos->last()->numCapitulo;
                            $ultimo = $capitulos->first()->numCapitulo;
                        } else {
                            $primeiro = '';
                            $ultimo = '';
                        }
                    @endphp
                    @empty($atual)
                        @empty($primeiro)
                        @else
                        <a href="{{route('capitulo',[$obra,str_replace('.0', '', $primeiro)])}}" class="btn red darken-4" style="margin-bottom:5px">
                            Ler primeiro capítulo
                        </a>
                        <a href="{{route('capitulo',[$obra,str_replace('.0', '', $ultimo)])}}" class="btn red darken-4" style="margin-bottom:5px">
                            Ler último capítulo
                        </a>
                        @endempty
                    @else
                        <a href="{{route('capitulo',[$obra,str_replace('.0', '', $atual)])}}" class="btn red darken-4" style="margin-bottom:5px">
                            Continuar Lendo
                        </a>
                    @endempty
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <blockquote><h5>SINOPSE</h5></blockquote>
        <p>
            {{$obra->sinopseObra}}
        </p>
    </div>
    @isset($obra->scan)
    <div class="divider"></div>
    <div class="row">
        @php $scan = $obra->scan; @endphp
        <blockquote><h5>SCAN RESPONSÁVEL</h5></blockquote>
        <div class="col s6 m3 l2">
            <img src="{{asset("storage/$scan->logo")}}" class="responsive-img"
                style="border-radius: 8px 20px; border: solid 2px #b71c1c">
        </div>
        <div class="col s6 m9 l10">
            <h5 class="bold" style="margin-top:0; color: #b71c1c">
                {{$obra->scan->nomeScan}}
            </h5>
            @isset($scan->twitter)
            <a href="{{$scan->twitter}}" target="_blank" style="padding-right:1.5rem">
                <i class="fab fa-twitter"></i>
            </a>
            @endisset
            @isset($scan->discord)
            <a href="{{$scan->discord}}" target="_blank" style="padding-right:1.5rem">
                <i class="fab fa-discord"></i>
            </a>
            @endisset
            @isset($scan->facebook)
            <a href="{{$scan->facebook}}" target="_blank" style="padding-right:1.5rem">
                <i class="fab fa-facebook-square"></i>
            </a>   
            @endisset
            @isset($scan->instagram)
            <a href="{{$scan->instagram}}" target="_blank" style="padding-right:1.5rem">
                <i class="fab fa-instagram"></i>
            </a>
            @endisset
            <div class="row">
                <a class="btn red darken-4" style="margin-top:0.2rem">Ver todos os Projetos</a>
            </div>
        </div>
    </div>
    @endisset
    <div class="divider"></div>
    <div class="row">
        <blockquote><h5>CAPÍTULOS</h5></blockquote>
        <div class="collection">
            @foreach ($capitulos as $capitulo)
                @php
                    $date = new DateTime($capitulo->created_at);
                    $date = $date->format('d/m/Y');
                    $pub = date_format($capitulo->created_at, 'Y-m-d H:i');
                    $atual = date('Y-m-d H:i');
                    $dif = strtotime($atual) - strtotime($pub);
                    $horas = (floor($dif/(60*60)));
                    $dif = floor($dif/(60*60*24));
                    $vip = $_COOKIE['vip'] ?? false;
                @endphp
                <a 
                    @if($horas < 2 && !$vip && $obra->scan_id == NULL)
                        class="collection-item black-text tooltipped" data-tooltip="Disponível para doadores!" data-position="top"
                    @else
                        href="{{route("capitulo",[$obra->id,str_replace('.0', '', $capitulo->numCapitulo)])}}" class="collection-item black-text"
                    @endif
                    >
                    Capítulo {{str_replace('.0', '', $capitulo->numCapitulo)}}
                    @if($dif > 2)
                        <span class="right grey-text" style="font-style:italic">{{$date}}</span>
                    @elseif ($dif < 1)
                        <span class="badge red darken-4 pulse white-text" style="font-size:0.8rem; position: sticky">NEW</span>
                    @else
                        <span class="right grey-text" style="font-style:italic">{{$dif}} dias atrás</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
    <div class="divider"></div>
    <blockquote><h5>COMENTÁRIOS</h5></blockquote>
    <div id="disqus_thread"></div>
    <script>
        var disqus_config = function () {
            this.page.url = '{{request()->url()}}';
        };
        (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://omega-scanlator.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
    </script>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();
            @if($nota > 0)    
                var stars = $('.rate input');
                stars[parseInt(5-{{$nota}})].checked = true;
            @endif
            $('.materialboxed').materialbox();
            $('.material-placeholder').addClass('z-depth-4');
            $('.material-placeholder').css('border-radius','8px 20px');
            $("input[type=radio]").click(function(e){
                var nota = $(this).val();
                $.get("{{route('avaliar',$obra->id)}}", {nota: nota}, function(data){
                    $("#nota").text(data+" / 5");
                    var stars = $('.rate input');
                    stars[parseInt(5-data)].checked = true;
                });
            });
        });
    </script>
    <script id="dsq-count-scr" src="//omega-scanlator.disqus.com/count.js" async></script>
@endsection