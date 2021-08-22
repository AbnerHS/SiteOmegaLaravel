@extends('layouts.style')
@section('title','Projetos')
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
    </style>
@endsection
@section('content')
    @empty($_COOKIE['vip'])
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
    <blockquote><h4>Projetos</h4></blockquote>
    <ul class="collapsible">
        <li>
            <div class="collapsible-header"><i class="material-icons">filter_list</i>Gêneros</div>
            <div class="collapsible-body">
                <div class="row" style="margin-bottom:0px">
                    @foreach ($generos as $genero)
                        <div class="col l4 s6" style="margin-bottom: 0.5rem">
                            <a href="{{route('search',['filtros' => $filtros, 'order' => $order ?? '', 'genero' => $genero->nome])}}" class="black-text valign-wrapper">
                                <i class="material-icons" style="font-size:1.2rem; margin-right: 0.5rem">play_arrow</i>
                                <span style="font-weight: 500">{{$genero->nome}} </span>
                                <span style="margin-left:0.3rem" class="grey-text text-darken-1">({{$genero->obras}})</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </li>
    </ul>
    <blockquote>
        <div class="row">
            <div class="col s12 m4">
                <h6 class="truncate">{{$linhas}} RESULTADO(S) @isset($filtros) PARA "{{strtoupper($filtros)}}"  @endisset</h6>
            </div>
            @php $order = request()->get('order'); @endphp
            <div class="col s12 m8" style="text-align: right">
                <a href="{{route('search',[
                    'filtros' => $filtros,'order' => 'a-z','genero' => $gen ?? ''
                    ])}}" class="btn-flat {{$order == 'a-z' ? 'red darken-4':'grey-text'}} text-darken-2 efeito">A-Z</a>
                <a href="{{route('search',[
                    'filtros' => $filtros,'order' => 'views','genero' => $gen ?? ''
                    ])}}" class="btn-flat {{$order == 'views' ? 'red darken-4':'grey-text'}} text-darken-2 efeito">Mais Views</a>
                <a href="{{route('search',[
                    'filtros' => $filtros,'order' => 'avaliacao','genero' => $gen ?? ''
                    ])}}" class="btn-flat {{$order == 'avaliacao' ? 'red darken-4':'grey-text'}} text-darken-2 efeito">Avaliação</a>
                <a href="{{route('search',[
                    'filtros' => $filtros,'order' => 'favoritos','genero' => $gen ?? '' 
                    ])}}" class="btn-flat {{$order == 'favoritos' ? 'red darken-4':'grey-text'}} text-darken-2 efeito">Favoritado</a>
            </div> 
        </div>
    </blockquote>

    <div class="divider"></div>
    <div class="row">
        @forelse ($obras as $obra)
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
                                        <p>
                                            <div class="chip" style="font-weight: unset">
                                                <a href="{{route('capitulo',[$obra->id,str_replace('.0', '', $cap->numCapitulo)])}}" style="color:black">Cap {{str_replace('.0', '', $cap->numCapitulo)}}</a>
                                            </div>
                                            @php
                                                $date = new DateTime($cap->created_at);
                                                $date = $date->format('d/m/Y');
                                            @endphp
                                            <span style="font-size:12px; position: absolute;line-height:2.25rem; right:0.8rem">
                                                {{$date}}
                                            </span>
                                        </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="height:400px"></div>
        @endforelse
    </div>
@endsection

@section('script')
    <script>
        $(".collapsible").collapsible();        
        @foreach($obras as $obra)
            var star = ($(".rate > input.{{$obra->id}}"));
            @if($obra->nota > 0)
                var nota = parseInt(5 - {{$obra->nota}});
                star[nota].checked = true;
            @endif
        @endforeach
    </script>    
@endsection