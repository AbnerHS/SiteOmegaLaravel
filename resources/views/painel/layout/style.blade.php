<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") - Omega Scan</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/materialize.css')}}" media="screen,projection">
    @yield('style')
    
</head>
<body>
    <header>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper red darken-4">
                    <ul class="left">
                        <li>
                            <a data-target="painelEsquerdo" class="sidenav-trigger">
                                <i class="material-icons">menu</i>
                            </a>
                        </li>
                    </ul>
                    <ul class="right">
                        <li>
                            <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="material-icons">exit_to_app</i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        </li>
                    </ul>
                    <a href="{{route('obras.index')}}" class="brand-logo center"><img style="max-height:-webkit-fill-available; padding-top: 6px; width:12rem" class="responsive-img" src="{{asset('logo.png')}}"></a>
                </div>
            </nav>
        </div>
    </header>
    <ul id="painelEsquerdo" class="sidenav sidenav-fixed" style="top: auto">
        @php $link = Request::segment(2); @endphp
        <li style="padding-left:15px"><h4><i class="material-icons">business</i> Painel</h4></li>
        <li {{$link == 'obras' ? "class=active":""}}>
            <a href="{{route('obras.index')}}" class="black-text">
                <i class="material-icons left black-text">art_track</i>Obras
            </a>
        </li>
        <li {{$link == 'autors' ? "class=active":""}}>
            <a href="{{route('autors.index')}}" class="black-text">
                <i class="material-icons left black-text">person</i>Autores
            </a>
        </li>
        <li {{$link == 'artistas' ? "class=active":""}}>
            <a href="{{route('artistas.index')}}" class="black-text">
                <i class="material-icons left black-text">brush</i>Artistas
            </a>
        </li>
        <li {{$link == 'generos' ? "class=active":""}}>
            <a href="{{route('generos.index')}}" class="black-text">
                <i class="material-icons left black-text">list</i>Gêneros
            </a>
        </li>
        <li {{$link == 'scans' ? "class=active":""}}>
            <a href="{{route('scans.show','home')}}" class="black-text">
               <i class="material-icons left black-text">account_box</i>Perfil da Scan
            </a>
        </li>
        <li {{$link == 'usuarios' ? "class=active":""}}>
            <a href="{{route('usuarios.index')}}" class="black-text">
                <i class="material-icons left black-text">group_add</i>Usuários
            </a>
        </li>
        <li {{$link == 'doacaos' ? "class=active":""}}>
            <a href="{{route('doacaos.index')}}" class="black-text">
                <i class="material-icons left black-text">insert_chart</i>Estatistica
            </a>
        </li>
        <li>
            <a href="{{route('index')}}" class="black-text">
                <i class="material-icons left black-text">chrome_reader_mode</i>Leitor
            </a>
        </li>
    </ul>

    <div class="container" style="margin-left: 320px">
        @yield("content")
    </div>

    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
    <script>
        function tamanhoTela(){
            if($(window).width() < 975)
                $(".container").css('margin-left','auto');
            else
                $(".container").css('margin-left','320px');
        }
        $(document).ready(function(){
            $(".sidenav").sidenav();
            $('.tooltipped').tooltip();
            tamanhoTela();
            
        });
        $(window).resize(function(){
            tamanhoTela();
        });
    </script>
    @yield('script')
</body>
</html>