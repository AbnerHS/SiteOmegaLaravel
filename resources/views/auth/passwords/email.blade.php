@extends('layouts.style')
@section("title","Recuperar Senha")
@section('content')
    <div class="row" style="margin-top: 55px; margin-bottom:50px">
        <div class="card center" style="margin-bottom:0px">
            <div class="card-content">
                <span class="card-title black-text">Recuperar Senha</span>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form id="formSenha" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-field">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-action row">
                <a class="btn-large col s12 offset-l9 l3 waves-effect waves-light red darken-2"
                        onclick="document.getElementById('formLogin').submit();">
                    Recuperar Senha
                </a>
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