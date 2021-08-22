@extends('layouts.style')
@section('title','Home')
@section('link')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endsection
@section('style')
    <style>
        .pagination li a{
            color: black;
        }
        .pagination li.active{
            background-color: #b71c1c;
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
            font-size:22px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate i{
            font-size:22px;
        }
        .slider .indicators .indicator-item.active{
            background-color: #b71c1c;
        }
        .thumb {
            position: relative;
            height: 350px;  
            overflow: hidden;
            margin-bottom:1rem;
        }
        .thumb img {
            position: absolute;
            left: 50%;
            top: 50%;
            height: 100%;
            width: auto;
            -webkit-transform: translate(-50%,-50%);
                -ms-transform: translate(-50%,-50%);
                    transform: translate(-50%,-50%);   
        }
        .thumb img.portrait {
            width: 90%;
            height: auto;
            filter: brightness(0.6);
        }
    </style>
@endsection
@section('content')
    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list center">
                @foreach ($destaques as $destaque)
                    <li class="splide__slide">
                        <a href="{{route('leitor.show',$destaque->id)}}">
                            <div style="z-index:2;width:90%;position: absolute; bottom:1.5rem;left:5%">
                                <h3 class="white-text">{{$destaque->tituloObra}}</h3>
                            </div>
                            <div class="thumb">
                                <img src="{{asset("storage/$destaque->capaObra")}}" class="portrait">
                            </div>
                        </a>
                    </li>   
                @endforeach
                <li class="splide__slide">
                    <a href="https://discord.gg/VpMdqZX2Gh" target="_blank">
                        <div class="thumb red darken-4">
                            <img src="{{asset("recrutamento.jpg")}}" style="width:100%;height:auto;max-height: 350px">
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @empty($_COOKIE['vip'])
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                style="display:inline-block;width:95%; height:90px; margin-left:2.5%"
                data-ad-client="ca-pub-4636385704936476"
                data-ad-slot="5657293816"></ins>
        <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endif
    <div class="row">
        <blockquote>
            <h5>Últimas Atualizações</h5>
        </blockquote>
    </div>
    <div class="row">
        @foreach ($obras as $obra)
        <div class="col l3 m4 s6">
            <div class="waves-effect waves-light hoverable" style="display:block; margin: 0.5rem 0 1rem 0">
                <a href="{{route('leitor.show', $obra->id)}}">
                    <div class="card-image" style="height: 200px; overflow:hidden">
                        <td><img src="{{asset("storage/$obra->capaObra")}}" style="max-height: auto" class="responsive-img"></td>
                    </div>
                </a>
                <div class="card-stacked">
                    <div class="card-content" style="padding: 5%;">
                        <p class="truncate black-text" style="margin-bottom:5px">{{$obra->tituloObra}}</p>
                        <div class="rate" style="margin-left:0px">
                            <input disabled class="{{$obra->id}}" type="radio" id="star1_{{$obra->id}}" name="rate{{$obra->id}}" value="1" />
                            <label for="star1_{{$obra->id}}" title="text"><i class="material-icons">grade</i></label>
                            <input disabled class="{{$obra->id}}" type="radio" id="star2_{{$obra->id}}" name="rate{{$obra->id}}" value="2" />
                            <label for="star2_{{$obra->id}}" title="text"><i class="material-icons">grade</i></label>
                            <input disabled class="{{$obra->id}}" type="radio" id="star3_{{$obra->id}}" name="rate{{$obra->id}}" value="3" />
                            <label for="star3_{{$obra->id}}" title="text"><i class="material-icons">grade</i></label>
                            <input disabled class="{{$obra->id}}" type="radio" id="star4_{{$obra->id}}" name="rate{{$obra->id}}" value="4" />
                            <label for="star4_{{$obra->id}}" title="text"><i class="material-icons">grade</i></label>
                            <input disabled class="{{$obra->id}}" type="radio" id="star5_{{$obra->id}}" name="rate{{$obra->id}}" value="5" />
                            <label for="star5_{{$obra->id}}" title="text"><i class="material-icons">grade</i></label>
                        </div>
                        <div class="row" style="margin-bottom: 10px;height:120px">
                            <div class="col s12">
                                @foreach ($obra->capitulos as $cap)
                                    @php
                                        $date = new DateTime($cap->created_at);
                                        $date = $date->format('d/m/Y');
                                        $pub = date_format($cap->created_at, 'Y-m-d H:i');
                                        $atual = date('Y-m-d H:i');
                                        $dif = strtotime($atual) - strtotime($pub);
                                        $horas = (floor($dif/(60*60)));
                                        $dias = floor($dif/(60*60*24));
                                        $vip = $_COOKIE['vip'] ?? false;
                                    @endphp
                                        @if($horas < 2 && !$vip && $obra->scan_id == NULL)
                                            <a class="tooltipped" data-tooltip="Disponível para doadores!" data-position="top" style="color:black">
                                        @else
                                            <a href="{{route('capitulo',[$obra->id,str_replace('.0', '', $cap->numCapitulo)])}}" style="color:black">
                                        @endif        
                                        <p>
                                            <div class="chip hoverable" style="font-weight: unset; @if($horas < 2 && !$vip && $obra->scan_id == NULL) filter:blur(1px);@endif">
                                                <span class="black-text">Cap {{str_replace('.0', '', $cap->numCapitulo)}}</span>
                                            </div>
                                            <span style="font-size:12px; position: absolute;line-height:2.25rem; right:0.8rem">
                                                @if($dias > 2)
                                                    {{$date}}
                                                @elseif($dias < 1)
                                                    @php
                                                        $min = $dif/60;
                                                        $hora = 0;
                                                        $dia = 0;
                                                        $valor = $min;
                                                        $tempo = "minutos";
                                                        if($min >= 60){
                                                            $hora = floor($min/60);
                                                            $valor = $hora;
                                                            $tempo = "horas";
                                                        }
                                                        if($hora >= 24){
                                                            $dia = floor($hora/24);
                                                            $valor = $dia;
                                                            $tempo = "dias";
                                                        }
                                                    @endphp
                                                    <span class="badge red darken-4 pulse white-text tooltipped" 
                                                        data-position="bottom" data-tooltip="{{$valor." ".$tempo}} atrás" 
                                                        style="font-size:0.8rem;margin-top:0.45rem">NEW</span>
                                                @elseif($dias == 1)
                                                    {{$dias}} dia atrás
                                                @else
                                                    {{$dias}} dias atrás
                                                @endif
                                            </span>
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col s12 center">
            {!!$obras->links()!!}
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.tooltipped').tooltip();
        });
        @foreach($obras as $obra)
            var star = ($(".rate > input.{{$obra->id}}"));
            @if($obra->nota > 0)
                var nota = parseInt(5 - {{$obra->nota}});
                star[nota].checked = true;
            @endif
        @endforeach
        $(document).ready(function(){
            new Splide('.splide',{
                type: 'slide',
                rewind: true,
                waitForTransition: false,
                arrows: false,
                autoplay: true,
                interval: 4000,
                perPage: 2,
                pagination: false,
                breakpoints : {
                    600: {
                        perPage: 1
                    }
                }
            }).mount();
        });
    </script>
@endsection