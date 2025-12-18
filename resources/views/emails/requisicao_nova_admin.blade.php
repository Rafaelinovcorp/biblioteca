@extends('emails.layout')

@section('content')
    <div class="header">
        Nova Requisição #{{ $requisicao->numero }}
    </div>

    @if($requisicao->livro->capa)
        <img src="{{ asset('storage/'.$requisicao->livro->capa) }}">
    @endif

    <p>
        O utilizador <strong>{{ $requisicao->user->name }}</strong>
        efetuou uma nova requisição.
    </p>

    <ul>
        <li><strong>Livro:</strong> {{ $requisicao->livro->nome }}</li>
        <li><strong>Email:</strong> {{ $requisicao->user->email }}</li>
        <li><strong>Entrega prevista:</strong> {{ $requisicao->data_fim_previsto->format('d/m/Y') }}</li>
    </ul>

    <a href="{{ url('/requisicoes') }}" class="btn">
        Gerir Requisições
    </a>
@endsection
