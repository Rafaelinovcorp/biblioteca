@extends('layouts.default')
@section('content')
<div class="flex gap-6">
    <div class="w-1/3">
        <img src="{{ $livro->capa ? asset('storage/'.$livro->capa) : 'https://via.placeholder.com/300' }}" alt="capa">
    </div>
    <div class="w-2/3">
        <h1 class="text-2xl font-bold">{{ $livro->nome }}</h1>
        <p class="text-sm">ISBN: {{ $livro->isbn }}</p>
        <p class="mt-4">{{ $livro->bibliografia }}</p>
        <p class="mt-2">Estado: <strong>{{ $livro->estado }}</strong></p>
        @if($livro->estado === 'disponivel')
            <a href="{{ route('requisicoes.create', ['livro_id' => $livro->id]) }}" class="btn mt-4">Requisitar</a>
        @endif

        <h3 class="mt-6">Histórico de Requisições</h3>
        <ul>
            @foreach($livro->requisicoes as $r)
                <li>#{{ $r->numero }} - {{ $r->estado }} - {{ $r->data_inicio->format('Y-m-d') }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
