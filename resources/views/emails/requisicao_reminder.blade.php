@extends('emails.layout')

@section('content')
    <div class="header">
        Lembrete de entrega
    </div>

    @if($requisicao->livro->capa)
        <img src="{{ asset('storage/'.$requisicao->livro->capa) }}">
    @endif

    <p>
        Olá <strong>{{ $requisicao->user->name }}</strong>,
    </p>

    <p>
        Relembramos que o livro
        <strong>{{ $requisicao->livro->nome }}</strong>
        deve ser entregue amanhã.
    </p>

    <ul>
        <li><strong>Entrega prevista:</strong> {{ $requisicao->data_fim_previsto->format('d/m/Y') }}</li>
    </ul>

    <a href="{{ url('/requisicoes') }}" class="btn">
        Ver Requisição
    </a>
@endsection
