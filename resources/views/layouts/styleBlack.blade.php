<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title") - Omega Scan</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/materialize.css')}}" media="screen,projection">
    <link rel="stylesheet" href="{{asset('css/efeito.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        ::-webkit-scrollbar-track-piece{
            background: #212121;
        }
        ::-webkit-scrollbar-thumb:vertical {
            background-color: #424242;
        }
    </style>
    @yield('style')
</head>
<body>
    <div class="row z-depth-3 red darken-4" style="margin:0" id="nav">
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
                <a style="font-size:1.25rem" class="btn-flat white-text efeito" href="#">
                    <i class="material-icons left">art_track</i>
                    PROJETOS
                </a>
                <a style="font-size:1.25rem" class="btn-flat white-text efeito" href="#">
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
                    <a class="btn-flat white-text efeito right" href="{{Auth::user()->tipo_usuario == 3 ? "#": route('obras.index')}}">
                        @php echo explode(' ', trim(Auth::user()->name))[0]; @endphp
                        <i class="material-icons left">account_box</i>
                    </a>
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
                <a href="#" data-target="side" class="sidenav-trigger btn-flat white-text"><i class="material-icons" style="font-size:2rem">menu</i></a>
            </div>
        </div>
    </div>
    </div>
    <ul class="sidenav" id="side">
        @auth
        <li>
            <a href="#" class="black-text">
                <i class="material-icons black-text">account_box</i> {{Auth::user()->name}}
            </a>
        </li>
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
            <a href="#" class="black-text">
                <i class="material-icons black-text">art_track</i>
                Projetos
            </a>
        </li>
        <li>
            <a href="#" class="black-text">
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
    <div class="container">
        @yield('content')
    </div>
    
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(document).ready(function(){
                $('.sidenav').sidenav();
            });
        });
    </script>
    @yield('script')
</body>
</html>