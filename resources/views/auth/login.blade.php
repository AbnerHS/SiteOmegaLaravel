@extends('layouts.style')
@section('title','Login')
@section('content')
    <div class="row" style="margin-top:55px; margin-bottom:0px">
        <div class="card center" style="margin-bottom:0px">
            <div class="card-content">
                <span class="card-title black-text">Login</span>
                <form id="formLogin" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-field">
                        <label for="email">E-Mail</label>
                        <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field">
                        <label for="password">Senha</label>
                        <input id="password" type="password" class="validate" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <p class="left-align">
                        <label>
                            <input type="checkbox" class="filled-in" name="remember" {{old('remember') ? 'checked' : '' }}>
                            <span>Lembrar</span>
                        </label>
                    </p>
                </form>
            </div>
            <div class="card-action row">
                <a class="btn-large col s12 offset-l2 l3 waves-effect waves-light red darken-2"
                        onclick="document.getElementById('formLogin').submit();">
                    Login
                </a>
                @if (Route::has('password.request'))
                    <a class="btn-large col s12 offset-l2 l3 waves-effect waves-light red darken-2" href="{{ route('password.request') }}">
                        Esqueci a Senha
                    </a>
                @endif            
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#formLogin").keydown(function(e){
            if(e.keyCode == 13)
                $(this).submit()
        });
    </script>
@endsection