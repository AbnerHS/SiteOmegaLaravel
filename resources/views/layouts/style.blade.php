<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Tradução e Edição de Mangás">
    <meta name="author" content="Omega Scanlator">
    <meta name="keywords" content="mangá, omega, scanlator, webtoon">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="mRxicDIr6x2t5gBxATFm6_Qk-cthiRxkO93ShC2SR08
    "/>
    <meta name="googlebot" content="index, follow" />
    <title>@yield("title") - Omega Scanlator</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/materialize.css')}}" media="screen,projection">
    <link rel="stylesheet" href="{{asset('css/efeito.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    @yield('link')
    <script data-ad-client="ca-pub-4636385704936476" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YH47N157Y1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', 'G-YH47N157Y1');
    </script>
    @yield('style')
    <style>
        body {
           display: flex;
           min-height: 100vh;
           flex-direction: column;
        }
        main {
            flex: 1 0 auto;
        }
        .dropdown-content li > a, .dropdown-content li > span{
            color: #b71c1c;
        }
        span.notifica{
            position: sticky;
            height: 1.2rem;
            width: 1.2rem;
            border-radius: 100%;
            line-height: 1.2rem;
            min-width: 1.2rem;
            padding: 0;
            font-size: 0.8rem;
            font-weight: 700;
        }
        span.notificaSmart{
            height: 0.5rem;
            width: 0.5rem;
            border-radius: 100%;
            position: absolute;
        }
   </style>
</head>
<body>
    <div style="display: block">
        <div class="row red darken-4" style="margin:0" id="nav">
            <div class="container">
                <div class="row valign-wrapper" style="margin:0">
                    <div class="col s6 m4 l3 center" style="margin-left:0">
                        <a href="{{route('index')}}" class="brand-logo center"><img style="max-height:-webkit-fill-available; padding-top: 6px" class="responsive-img" src="{{asset('logo.png')}}"></a>
                    </div>
                    <div class="col s5 m6 l6 center hide-on-med-and-down">
                        <a style="font-size:1.25rem" class="btn-flat white-text efeito" href="{{route('index')}}">
                            <i class="material-icons left">home</i>
                            HOME
                        </a>
                        <a style="font-size:1.25rem" class="btn-flat white-text efeito" href="{{route('projeto')}}">
                            <i class="material-icons left">art_track</i>
                            PROJETOS
                        </a>
                        <a style="font-size:1.25rem" class="btn-flat white-text efeito" href="{{route('doacao')}}">
                            <i class="material-icons left">monetization_on</i>
                            DOAÇÕES
                        </a>
                    </div>
                    <div class="col m6 l3 center hide-on-small-only">
                        @auth   
                            <a class="btn-flat white-text efeito right" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                <i class="material-icons">exit_to_app</i>
                            </a>
                            @php
                                $notificacao = $_COOKIE['notificacao'];
                            @endphp
                            <!-- Botao perfil -->
                            @if(Auth::user()->tipo_usuario == 3)
                            <a class="btn-flat white-text efeito right" href="{{route('perfil.index')}}">
                                @empty($notificacao)
                                @else
                                    <span class="badge white red-text pulse notifica">{{$notificacao}}</span>    
                                @endempty
                                @php echo explode(' ', trim(Auth::user()->name))[0]; @endphp
                                <i class="material-icons left">account_box</i>
                            </a>
                            @else
                            <!-- Botao painel e perfil -->
                            <a class='dropdown-trigger btn-flat efeito right' data-target='dropdown'>
                                @empty($notificacao)
                                @else
                                    <span class="badge white red-text pulse notifica">{{$notificacao}}</span>    
                                @endempty
                                @php echo explode(' ', trim(Auth::user()->name))[0]; @endphp
                                <i class="material-icons left">account_box</i>
                            </a>
                            <ul id='dropdown' class='dropdown-content'>
                                <li><a href="{{route('painel')}}">Painel</a></li>
                                <li><a href="{{route('perfil.index')}}">Perfil</a></li>
                            </ul>
                            @endif
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a class="btn-flat white-text efeito right" href="{{route('register')}}">
                                Cadastrar
                            </a>    
                            <a class="btn-flat white-text efeito right" href="{{route('login')}}">
                                Acessar
                            </a>
                        @endauth
                    </div>
                    <div class="col s2 m1 hide-on-large-only">    
                        <a href="#" data-target="side" class="sidenav-trigger btn-flat white-text"><i class="material-icons" style="font-size:2rem">menu</i>
                            @empty($notificacao)
                            @else
                                <span class="notificaSmart white"></span>    
                            @endempty
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @php 
            $request = Request::segments();
            if(!empty($request[0])){
                if(!empty($request[2]))
                    $request = !($request[0] == "login" || $request[0] == "register" || $request[2] == "capitulo");
                else
                    $request = !($request[0] == "login" || $request[0] == "register");
            } else
                $request = true;
        @endphp
        @if($request)
        <nav class="nav-wrapper white black-text" style="height: 3.5rem">
            <div class="container">
                <form action="{{route('search')}}" class="left formPesquisa">
                    <div class="input-field">
                        <input id="search" type="search" name="filtros" required style="height: 3.5rem">
                        <label class="label-icon" for="search" style="left:0">
                            <i class="material-icons " style="line-height: 3.5rem; font-size:2rem">search</i>
                        </label>
                    </div>
                </form>
                <a href="https://twitter.com/omegascans" target="_blank" class="navIcon right">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://discord.gg/VpMdqZX2Gh" target="_blank" class="navIcon right">
                    <i class="fab fa-discord"></i>
                </a>
                <a href="https://www.facebook.com/OmegaScalator/" target="_blank" class="navIcon right">
                    <i class="fab fa-facebook-square"></i>
                </a>                   
            </div>
        </nav>
        <div id="result" class="z-depth-2">
        </div>
        @endif
    </div>
    <ul class="sidenav" id="side">
        @auth
            <li>
                <a href="{{route('perfil.index')}}">
                    @empty($notificacao)
                    @else
                        <span class="badge red darken-4 white-text pulse notifica">{{$notificacao}}</span>    
                    @endempty
                    <i class="material-icons black-text">account_box</i>{{Auth::user()->name}}
                </a>
            </li> 
            @if(Auth::user()->tipo_usuario < 3)
                <li>
                    <a href="{{route('painel')}}" class="black-text">
                        <i class="material-icons black-text">business</i> Painel
                    </a>
                </li>
            @endif
        @else
        <li>
            <a href="{{route('login')}}" class="black-text">
                <i class="material-icons black-text">account_box</i>
                Acessar
            </a>
        </li>
        <li>
            <a href="{{route('register')}}" class="black-text">
                <i class="material-icons black-text">person_add</i>
                Cadastrar
            </a>
        </li>
        @endauth
        <li>
            <a href="{{route('index')}}" class="black-text">
                <i class="material-icons black-text">home</i>
                Home
            </a>
        </li>
        <li>
            <a href="{{route('projeto')}}" class="black-text">
                <i class="material-icons black-text">art_track</i>
                Projetos
            </a>
        </li>
        <li>
            <a href="{{route('doacao')}}" class="black-text">
                <i class="material-icons black-text">monetization_on</i>
                Doações
            </a>
        </li>
        @auth
        <li>
            <a class="black-text" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                <i class="material-icons black-text">exit_to_app</i>
                Sair
            </a>
        </li>
        @endauth
    </ul>
    <main class="container">  
        <div style="margin-top:3rem">
            @yield('content')
        </div>
    </main>
    <footer class="page-footer red darken-4">
        <div class="container">
          <div class="row valign-wrapper">
            <div class="col l6 s12 left">
              <h5 class="white-text">Omega Scanlator</h5>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <a class="grey-text text-lighten-3" href="https://discord.gg/VpMdqZX2Gh" target="_blank">Discord |</a>
                <a class="grey-text text-lighten-3" href="https://twitter.com/omegascans" target="_blank">Twitter |</a>
                <a class="grey-text text-lighten-3" href="https://www.facebook.com/OmegaScalator/" target="blank_">Facebook |</a>
                <a class="grey-text text-lighten-3" href="https://instagram.com/omegascans" target="_blank">Instagram</a>
            </div>
          </div>
        </div>
        <div class="footer-copyright">
          <div class="container">
            © 2020 - 2021 Copyright - OMEGA SCANLATOR - Todos os direitos reservados.
          </div>
        </div>
    </footer>
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.sidenav').sidenav();
            var elems = document.querySelectorAll('.dropdown-trigger');
            var instances = M.Dropdown.init(elems, {
                'hover' : true,
                'coverTrigger' : false
            });
            $("#search").keyup(function(e){
                var filtro = e.target.value;
                var conteudo = "<ul class='collection'>";
                if(filtro){
                    $("#result").show();
                    $.get("{{route('searchField')}}", {filtro : filtro}, function(data){
                        data.forEach(function(obra){
                            conteudo = conteudo.concat("<li class='collection-item avatar'>");
                            conteudo = conteudo.concat("<a class='black-text title' href='/leitor/"+obra.id+"'>");
                            conteudo = conteudo.concat("<img class='circle' src='../storage/"+obra.capaObra+"'>")
                            conteudo = conteudo.concat("<span class='title'>",obra.tituloObra,"</span></a>");
                            if(obra.genero[0]){    
                                conteudo = conteudo.concat("<p>",obra.genero[0].nome);
                            }
                            conteudo = conteudo.concat("<br>",obra.status);
                            conteudo = conteudo.concat('<a href="leitor/'+obra.id+'/fav" class="secondary-content">');
                            conteudo = conteudo.concat('<i class="material-icons ');
                            conteudo = conteudo.concat(obra.favorito ? 'yellow':'grey');
                            conteudo = conteudo.concat('-text">grade</i></a></li>');
                        });
                        conteudo += "</ul>";
                        $("#result").html(conteudo);
                    });
                } else {
                    $("#result").html("");
                    $("#result").hide();
                }
            });
            var div = document.getElementById("result")
            if(div){
                $(document).click(function(e){
                    if(!div.contains(e.target)){
                        $("#result").html("");
                        $("#result").hide();
                    }
                });
            }
        });
    </script>
    @yield('script')
    <script type="text/javascript" src="{{asset('js/blockadblock.js')}}"></script>
    <script>
        $('img').bind('contextmenu', function(e){
            return false;
        }); 
        function adBlockDetected() {
            alert('AdBlock está ativado! Graças aos anúncios, podemos manter este site gratuito');
            //$("html").load('adblock.html');
        }
        if(typeof blockAdBlock === 'undefined') {
            adBlockDetected();
        } else {
            blockAdBlock.onDetected(adBlockDetected);
        }
        blockAdBlock.setOption({
            debug: false,
            checkOnLoad: true,
            resetOnEnd: true
        });
    </script>
    @if(session('erro'))
        <script>
            M.toast({html: "{{session('erro')}}"});
        </script>
    @endif
</body>
</html>