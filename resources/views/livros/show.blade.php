@extends('layouts.default')

@section('content')

<div class="flex gap-6">
    <div class="w-1/3">
        <img
            src="{{ $livro->capa ? asset('storage/'.$livro->capa) : 'https://via.placeholder.com/300' }}"
            alt="capa"
            class="rounded shadow"
        >
    </div>

    <div class="w-2/3">
        <h1 class="text-2xl font-bold">{{ $livro->nome }}</h1>

        <p class="text-sm text-gray-500">
            ISBN: {{ $livro->isbn ?? '—' }}
        </p>

        @if($livro->categoria)
            <p class="mt-2">
                Categoria:
                <span class="font-semibold">
                    {{ $livro->categoria->nome }}
                </span>
            </p>
        @endif

        <p class="mt-4">
            {{ $livro->bibliografia }}
        </p>

        <p class="mt-2">
            Estado:
            <strong>{{ $livro->estado }}</strong>
        </p>

        {{-- BOTÃO REQUISITAR --}}
        @if($livro->estado === 'disponivel')
            <a
                href="{{ route('requisicoes.create', ['livro_id' => $livro->id]) }}"
                class="btn mt-4"
            >
                Requisitar
            </a>
        @endif

        {{-- BOTÃO AVISAR QUANDO DISPONÍVEL --}}
        @if($livro->estado === 'ocupado' && auth()->check() && !$alertaJaExiste)
            <form
                method="POST"
                action="{{ route('alertas.store') }}"
                class="mt-4"
            >
                @csrf
                <input type="hidden" name="livro_id" value="{{ $livro->id }}">

                <button class="btn btn-warning">
                    🔔 Avisar quando disponível
                </button>

                @if ($livro->estado === 'disponivel')
    <form method="POST" action="{{ route('carrinho.add', $livro) }}" class="mt-4">
        @csrf
        <button class="btn btn-primary">
            🛒 Adicionar ao Carrinho
        </button>
    </form>
@endif


            </form>
        @endif

        {{-- MENSAGEM SE JÁ PEDIU ALERTA --}}
        @if($livro->estado === 'indisponivel' && $alertaJaExiste)
            <p class="mt-4 text-sm text-gray-500">
                🔔 Já estás registado para ser avisado quando este livro ficar disponível.
            </p>
        @endif

        <h3 class="mt-6 font-semibold">Histórico de Requisições</h3>
        <ul class="list-disc ml-6">
            @foreach($livro->requisicoes as $r)
                <li>
                    #{{ $r->numero }} —
                    {{ $r->estado }} —
                    {{ $r->data_inicio->format('Y-m-d') }}
                </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- REVIEWS --}}
@if($livro->reviews->where('estado', 'ativa')->count())
    <div class="mt-10">
        <h3 class="text-lg font-bold mb-4">Reviews dos Leitores</h3>

        <div class="space-y-4">
            @foreach($livro->reviews->where('estado', 'ativa') as $review)
                <div class="card bg-base-100 shadow p-4">
                    <p class="font-semibold">
                        {{ $review->user->name }}
                    </p>

                    @if($review->rating)
                        <p>⭐ {{ $review->rating }}/5</p>
                    @endif

                    <p class="mt-2">
                        {{ $review->comentario }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endif

{{-- RECOMENDAÇÕES --}}
@if($relacionados->isNotEmpty())
    <h2 class="text-xl font-semibold mt-8 mb-4">📚 Recomendações</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($relacionados as $r)
            <a href="{{ route('livros.show', $r) }}"
               class="card bg-base-200 shadow hover:shadow-lg transition">
                <div class="card-body">
                    <h3 class="font-semibold">{{ $r->nome }}</h3>
                    <p class="text-sm opacity-70">{{ $r->categoria->nome }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endif

@endsection
