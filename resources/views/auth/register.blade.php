@extends('layouts.style')
@section('title','Cadastro')
@section('content')

    <div class="row" style="margin-top:20px; margin-bottom:0px" >
        <div class="card center" style="margin-bottom:0px">
            <div class="card-content">
                <span class="card-title black-text">Cadastro</span>
                <form id="formRegister" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-field">
                        <label for="name">Nome</label>
                        <input id="name" type="text" class="validate" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field">
                        <label for="password">Senha</label>
                        <input id="password" type="password" class="validate" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-field">
                        <label for="password-confirm">Confirmar Senha</label>
                        <input id="password-confirm" type="password" class="validate" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </form>
            </div>
            <div class="card-action row">
                <a class="btn-large col s12 l3 right waves-effect waves-light red darken-2"
                        onclick="document.getElementById('formRegister').submit();">
                    Cadastrar
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#formRegister").keydown(function(e){
            if(e.keyCode == 13)
                $(this).submit()
        });
    </script>
@endsection
