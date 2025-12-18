@extends('emails.layout')

@section('content')
    <div class="header">
        Requisição #{{ $requisicao->numero }} confirmada
    </div>

    @if($requisicao->livro->capa)
        <img src="{{ asset('storage/'.$requisicao->livro->capa) }}">
    @endif

    <p>Olá <strong>{{ $requisicao->user->name }}</strong>,</p>

    <p>
        A tua requisição do livro
        <strong>{{ $requisicao->livro->nome }}</strong>
        foi registada com sucesso.
    </p>

    <ul>
        <li><strong>Data início:</strong> {{ $requisicao->data_inicio->format('d/m/Y') }}</li>
        <li><strong>Entrega prevista:</strong> {{ $requisicao->data_fim_previsto->format('d/m/Y') }}</li>
    </ul>

    <a href="{{ url('/requisicoes') }}" class="btn">
        Ver Requisição
    </a>
@endsection
