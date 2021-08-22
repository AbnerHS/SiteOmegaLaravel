@extends('layouts.style')
@section('title','Doação')
@section('style')
    <style>
        p{
            font-size:1.2rem;
        }
    </style>
@endsection
@section('content')
    <blockquote><h3>Doações</h3></blockquote>
    <p style="font-weight:600">Aos que querem nos apoiar e ajudar a Scan a manter o site no ar, vocês podem fazer doações das seguintes maneiras:<br>
    <span style="font-weight:initial">Melhor opção para doadores esporádicos. (Que pretendem doar uma vez só, um valor especifico):</span></p>
    <a href="https://picpay.me/gabriel.augusto321" target="_blank">    
        <img src="{{asset('picpay.jpg')}}" width="300px" alt="">
    </a>
    <p>Melhor opção para doadores frequentes. (Que pretendem apoiar a Scan com um valor mensalmente de maneira automática):</p>
    <a href="https://www.padrim.com.br/omegascanlator" target="_blank">
        <img width="300px" src="{{asset('padrim.jpg')}}" alt="Acessar">
    </a>
    <p>A doação e voluntária e qualquer valor ajuda!<br>
    Assim você nos incentiva cada vez mais a continuar com nosso trabalho e a melhorar a qualidade dos nossos projetos.<br>
    Qualquer dúvida favor chamar um ADM.<br>
    Nós da equipe Omega agradecemos sua ajuda!</p>
    
@endsection