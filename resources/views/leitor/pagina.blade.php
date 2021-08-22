@extends('layouts.style')
@section('title','Leitura')
@section('style')
    <style>
        .btn-proximo{
            position: fixed;
            right: 5px;
            top:50%;
        }
        .btn-anterior{
            position: fixed;
            left: 5px;
            top:50%;
        }
        .btn-subir{
            position: fixed;
            bottom:5px;
            right:5px;
            cursor: pointer;
            display: none;
        }
        #subir{
            font-size:2rem;
        }
        img {
            -webkit-touch-callout: none;  
            -webkit-user-select: none;    
            -khtml-user-select: none;     
            -moz-user-select: none;       
            -ms-user-select: none;        
            user-select: none;            
        }
    </style>
@endsection
@section('content')
@php
    $tipo = $_COOKIE['tipo'] ?? 'list';
@endphp
    <div style="margin-top:3rem"></div>
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
    <a class="btn-flat waves-effect btn-subir"><i class="material-icons white-text" id="subir">arrow_upward</i></a>
    <div class="row valign-wrapper" style="margin-bottom: 0">
        <div class="col s6 l6">
            <blockquote class="black-text" id="nome">
                <h4>{{$nome}}</h4>
                <span style="font-size:1.2rem">Capítulo {{str_replace('.0', '', $num)}}</span>
            </blockquote>
        </div>
        <div class="col s6 l6 right">
            <select id="tipo" class="browser-default red darken-4 col offset-l1 l5" style="color:white;border: none">
                <option value="list">Infinito</option>
                <option value="page">Por Página</option>
            </select>
            <select id="capitulo" class="browser-default red darken-4 col offset-l1 l5" style="color:white;border: none">
              @foreach ($capitulos as $cap)
                <option value="{{str_replace('.0', '', $cap->numCapitulo)}}">Capítulo {{str_replace('.0', '', $cap->numCapitulo)}}</option>
              @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @if(!$primeiro)
            <a href="{{route('capitulo',[$obra,$anterior])}}" class="btn-flat btn-anterior hide-on-med-and-up">
                <i class="material-icons white-text" id="anterior" style="font-size:2rem">arrow_back</i>
            </a>
            <a href="{{route('capitulo',[$obra,$anterior])}}" class="btn red darken-4 hide-on-small-only">
                <i class="material-icons left" style="margin-right:0">arrow_back</i>
                Anterior
            </a>
            @else
            <a href="{{route('leitor.show',$obra)}}" class="btn red darken-4 hide-on-small-only">
                <i class="material-icons left" style="margin-right:0">arrow_back</i>
                Página do Projeto
            </a>
            @endif
            @if(!$ultimo)
            <a href="{{route('capitulo',[$obra,$proximo])}}" class="btn-flat btn-proximo hide-on-med-and-up">
                <i class="material-icons white-text" id="proximo" style="font-size:2rem">arrow_forward</i>
            </a>
            <a href="{{route('capitulo',[$obra,$proximo])}}" class="btn red darken-4 hide-on-small-only">
                <i class="material-icons right" style="margin-left:0">arrow_forward</i>
                Próximo
            </a>
            @else
                @if(!$primeiro)
                    <a href="{{route('leitor.show',$obra)}}" class="btn red darken-4 hide-on-small-only">
                        <i class="material-icons right" style="margin-left:0">arrow_forward</i>
                        Página do Projeto
                    </a>
                @endif
            @endif
            <div class="right valign-wrapper">
                @if($tipo == 'page')
                    <div class="left" style="margin-right:1rem">
                        <span class="white-text">Página <span id="nPagina"></span></span>
                    </div>
                @endif
                <a class="btn-floating btn-small waves-effect waves-light red darken-4 right" id="modoChange" style="margin-right: 0.5rem">
                    <i class="material-icons white-text">tonality</i>
                </a>
                @php
                    $favoritada = false;
                    if($user = Auth::user()){
                        if($user->favoritos()->where('obra_id',$obra)->exists())
                            $favoritada = true;
                        else
                            $favoritada = false;
                    }
                @endphp
                <a href="{{route('favoritar',$obra)}}" class="btn-floating btn-small waves-effect waves-light red darken-4 right" style="margin-right:0.5rem">
                    <i class="material-icons {{$favoritada ? 'red':'white'}}-text text-darken-4">favorite</i>
                </a>
            </div>
        </div>
    </div>
    <div class="row center">
        <div class="col offset-s1 s10">
            @if($tipo == 'list')
                @foreach ($paginas as $pagina)
                    <center>
                        <img class="responsive-img" style="vertical-align: middle; display: block" src="{{asset("storage/$pagina->imagemPagina")}}" alt="">
                    </center>
                @endforeach
            @endif
            @if($tipo == 'page')
            <center>
                <div class="imagem" style="cursor: pointer;">
                    <div id="loading" class="preloader-wrapper big active" style="position: fixed; top:50%">
                        <div class="spinner-layer spinner-red-only">
                          <div class="circle-clipper left">
                            <div class="circle"></div>
                          </div><div class="gap-patch">
                            <div class="circle"></div>
                          </div><div class="circle-clipper right">
                            <div class="circle"></div>
                          </div>
                        </div>
                    </div>
                    <img class="responsive-img" id="imagemPagina" style="vertical-align: middle; display: block">
                </div>
            </center>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 30px">
        <div class="col s12">
            @if(!$primeiro)
            <a href="{{route('capitulo',[$obra,$anterior])}}" class="btn red darken-4">
                <i class="material-icons left" style="margin-right:0">arrow_back</i>
                Anterior
            </a>
            @else
            <a href="{{route('leitor.show',$obra)}}" class="btn red darken-4">
                <i class="material-icons left" style="margin-right:0">arrow_back</i>
                Página do Projeto
            </a>
            @endif
            @if(!$ultimo)
            <a href="{{route('capitulo',[$obra,$proximo])}}" class="btn red darken-4">
                <i class="material-icons right" style="margin-left:0">arrow_forward</i>
                Próximo
            </a>
            @else
                @if(!$primeiro)
                    <a href="{{route('leitor.show',$obra)}}" class="btn red darken-4">
                        <i class="material-icons right" style="margin-left:0">arrow_forward</i>
                        Página do Projeto
                    </a>
                @endif
            @endif
        </div>
    </div>
    <div class="divider"></div>
    <div style="margin-bottom:1rem"></div>
    @if($_COOKIE['vip']??false)
    @else
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>    
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-4636385704936476"
                data-ad-slot="7509168206"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    @endif
    <div style="margin-top:1rem"></div>
    <div class="divider"></div>
    <blockquote><h5 class="black-text" id="coment">Comentários</h5></blockquote>
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
    <script src="{{asset('js/cookie.js')}}"></script>
    <script>
        var tipo = getCookie('tipo');
        if(tipo.length > 0 && tipo != '{{$tipo}}'){
            window.location.href = '/../leitor/{{$obra}}/capitulo/{{$num}}/'+tipo;
        }
        var modo = getCookie('modo');
        if(modo.length > 0){
            if(modo == 'light'){
                light();
            } 
            if(modo == 'dark') {
                dark();
            }
        }
        function dark(){
            $("blockquote").css('border-left','5px solid #424242')
            $("#nome").addClass('white-text');
            $("#subir").addClass('white-text');
            $("#coment").addClass('white-text');
            $("#proximo").addClass('white-text');
            $("#anterior").addClass('white-text');
            $("#nome").removeClass('black-text');
            $("#subir").removeClass('black-text');
            $("#coment").removeClass('black-text');
            $("#proximo").removeClass('black-text');
            $("#anterior").removeClass('black-text');
            $("footer").addClass(['grey','darken-3']);
            $("footer").removeClass(['red','darken-4']);
            $(".btn").removeClass(['red','darken-4']);
            $(".btn-floating").removeClass(['red','darken-4']);
            $("select").addClass(['grey','darken-3']);
            $(".btn-floating").addClass(['grey','darken-3']);
            $("#nav").removeClass(['red','darken-4']);
            $("select").removeClass(['red','darken-4']);
            $("#nav").addClass(['grey','darken-3'])
            $(".btn").addClass(['grey','darken-3']);
            $("body").addClass(['grey','darken-4']);
        }
        function light(){
            $("blockquote").css('border-left','5px solid #ee6e73');
            $("#nome").addClass('black-text');
            $("#subir").addClass('black-text');
            $("#coment").addClass('black-text');
            $("#proximo").addClass('black-text');
            $("#anterior").addClass('black-text');
            $("#nome").removeClass('white-text');
            $("#subir").removeClass('white-text');
            $("#coment").removeClass('white-text');
            $("#proximo").removeClass('white-text');
            $("#anterior").removeClass('white-text');
            $(".btn").removeClass(['grey','darken-3']);
            $("select").addClass(['red','darken-4']);
            $(".btn").addClass(['red','darken-4']);
            $(".btn-floating").removeClass(['grey','darken-3']);
            $(".btn-floating").addClass(['red','darken-4']);
            $("#nav").addClass(['red','darken-4']);
            $("select").removeClass(['grey','darken-3']);
            $("#nav").removeClass(['grey','darken-3']);
            $("body").removeClass(['grey','darken-4']);
            $("footer").removeClass(['grey','darken-3']);
            $("footer").addClass(['red','darken-4']);
        }
        
        $('#modoChange').click(function(){
            modo = getCookie('modo');
            if(modo.length == 0){
                setCookie('modo','dark',365);
                dark();
            }
            if(modo == 'dark'){
                setCookie('modo','light',365);
                light();
            }
            if(modo == 'light'){
                setCookie('modo','dark',365);
                dark();
            }
        });
        $('.btn-subir').click(function(){
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
        $(window).scroll(function(){
            if($(this).scrollTop() >= 500){
                $(".btn-subir").fadeIn();
            } else {
                $(".btn-subir").fadeOut();
            }
        });
        $("#capitulo>option[value='{{$num}}']").attr('selected',true);
        $("#capitulo>option[value='{{$num}}']").attr('disabled',true);
        $("#capitulo").change(function(e){
            window.location.href = '/../leitor/{{$obra}}/capitulo/'+$(this).val();
        });
        $("#tipo>option[value={{$tipo}}]").attr('selected',true);
        $("#tipo>option[value={{$tipo}}]").attr('disabled',true);
        $("#tipo").change(function(e){
            setCookie('tipo',$(this).val(),365);
            window.location.reload();
        });
        @if($tipo == 'page')
            var lista = Array();
            @foreach($paginas as $pagina)
                lista.push("{{$pagina->imagemPagina}}");
            @endforeach
            var pagina = getCookie('page_{{$obra}}_{{$num}}');
            if(!pagina){
                setCookie('page_{{$obra}}_{{$num}}','0',1);
                pagina = 0;
            }
            $("#nPagina").text(pagina);
            var link = "{{asset('storage')}}/";
            $("#imagemPagina").attr('src',link+lista[pagina]);
            $("#imagemPagina").on('load',function(){
                $("#loading").hide();
            });
            $(".imagem").click(function(e){
                var meio = window.innerWidth / 2;
                if(e.originalEvent.screenX > meio){
                    if(pagina < lista.length-1)
                        pagina++; 
                } else {
                    if(pagina >= 1)
                        pagina--;
                }
                mudarPagina();
            });
            $(document).keyup(function(e){
                if(e.keyCode == 39){
                    if(pagina < lista.length-1)
                        pagina++; 
                }
                if(e.keyCode == 37){
                    if(pagina >= 1)
                        pagina--;   
                }
                mudarPagina();
            });
        @else
            $(document).keyup(function(e){
                if(e.keyCode == 37)
                    window.location.href = "{{route('capitulo',[$obra,$anterior])}}";
                if(e.keyCode == 39)
                    window.location.href = "{{route('capitulo',[$obra,$proximo])}}";
            });
        @endif
        function mudarPagina(){
            $("#loading").show();
            setCookie('page_{{$obra}}_{{$num}}',pagina,1);
            $("#imagemPagina").attr("src",link+lista[pagina]);
            $("#nPagina").text(pagina);
        }
    </script>
    <script id="dsq-count-scr" src="//omega-scanlator.disqus.com/count.js" async></script>
@endsection