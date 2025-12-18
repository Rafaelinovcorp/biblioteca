@extends('layouts.default')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl">
            Requisição #{{ $requisicao->numero }}
        </h2>

        <a href="{{ route('requisicoes.index') }}"
           class="btn btn-sm btn-outline">
            Voltar
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- ESTADO --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Estado</h3>

        <span class="badge
            @if($requisicao->estado === 'pendente') badge-warning
            @elseif($requisicao->estado === 'confirmado') badge-info
            @elseif($requisicao->estado === 'entregue') badge-success
            @else badge-neutral
            @endif">
            {{ ucfirst($requisicao->estado) }}
        </span>
    </div>

    {{-- LIVRO --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Livro</h3>

        @if($requisicao->livro)
            <p class="font-semibold">
                {{ $requisicao->livro->nome }}
            </p>

            @if($requisicao->livro->editora)
                <p class="text-sm text-gray-500">
                    Editora: {{ $requisicao->livro->editora->nome }}
                </p>
            @endif
        @else
            <p class="text-error">
                Livro associado não encontrado.
            </p>
        @endif
    </div>

    {{-- CIDADÃO --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Cidadão</h3>

        @if($requisicao->user)
            <p class="font-semibold">
                {{ $requisicao->user->name }}
            </p>
            <p class="text-sm text-gray-500">
                {{ $requisicao->user->email }}
            </p>
        @else
            <p class="text-error">
                Utilizador associado não encontrado.
            </p>
        @endif
    </div>

    {{-- DATAS --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Datas</h3>

        <ul class="space-y-1 text-sm">
            <li>
                <strong>Início:</strong>
                {{ $requisicao->data_inicio?->format('d/m/Y') ?? '-' }}
            </li>

            <li>
                <strong>Entrega prevista:</strong>
                {{ $requisicao->data_fim_previsto?->format('d/m/Y') ?? '-' }}
            </li>

            @if($requisicao->data_fim_real)
                <li>
                    <strong>Entrega real:</strong>
                    {{ $requisicao->data_fim_real->format('d/m/Y') }}
                </li>
            @endif
        </ul>
    </div>

</div>
@endsection
