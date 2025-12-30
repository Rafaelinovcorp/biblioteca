@extends('layouts.default')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl">
            Requisição #{{ $requisicao->numero }}
        </h2>

        <a href="{{ route('requisicoes.index') }}"
           class="btn btn-outline btn-sm">
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
            @elseif($requisicao->estado === 'devolucao_pedida') badge-accent
            @elseif($requisicao->estado === 'entregue') badge-success
            @else badge-neutral
            @endif">
            {{ ucfirst(str_replace('_', ' ', $requisicao->estado)) }}
        </span>
    </div>

    {{-- LIVRO --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Livro</h3>

        <p class="font-semibold">
            {{ $requisicao->livro->nome }}
        </p>

        @if($requisicao->livro->editora)
            <p class="text-sm text-gray-500">
                Editora: {{ $requisicao->livro->editora->nome }}
            </p>
        @endif
    </div>

    {{-- CIDADÃO --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Cidadão</h3>

        <p class="font-semibold">
            {{ $requisicao->user->name }}
        </p>
        <p class="text-sm text-gray-500">
            {{ $requisicao->user->email }}
        </p>
    </div>

    {{-- DATAS --}}
    <div class="card bg-base-100 shadow p-4">
        <h3 class="font-bold mb-2">Datas</h3>

        <ul class="space-y-1 text-sm">
            <li><strong>Início:</strong> {{ $requisicao->data_inicio->format('d/m/Y') }}</li>
            <li><strong>Entrega prevista:</strong> {{ $requisicao->data_fim_previsto->format('d/m/Y') }}</li>

            @if($requisicao->data_fim_real)
                <li><strong>Entrega real:</strong> {{ $requisicao->data_fim_real->format('d/m/Y') }}</li>
            @endif
        </ul>
    </div>

@if(
    auth()->id() === $requisicao->user_id &&
    in_array($requisicao->estado, ['confirmado', 'devolucao_pedida'])
)
<div class="card bg-base-100 shadow p-4">
{{-- DOWNLOAD / INFO PDF --}}


    @if($requisicao->livro->pdf_path)
        <a href="{{ route('requisicoes.download', $requisicao) }}"
           class="btn btn-secondary btn-sm">
            📥 Download PDF
        </a>
    @else
        <div class="text-sm text-gray-500 italic">
            📄 Não existe PDF disponível para este livro.
        </div>
    @endif


   </div>
@endif

    {{-- AÇÕES --}}
    <div class="card bg-base-100 shadow p-6">
        <h3 class="font-bold text-lg mb-4">Ações</h3>

        <div class="flex flex-wrap gap-3">

            {{-- AÇÕES DO REQUISITANTE (CIDADÃO ou ADMIN) --}}
            @if(auth()->id() === $requisicao->user_id)

                @if($requisicao->estado === 'pendente')
                    <form method="POST" action="{{ route('requisicoes.cancelar', $requisicao) }}">
                        @csrf
                        <button class="btn btn-outline btn-error btn-sm">
                            Cancelar
                        </button>
                    </form>
                @endif

                @if($requisicao->estado === 'confirmado')
                    <form method="POST"
                          action="{{ route('requisicoes.pedirDevolucao', $requisicao) }}">
                        @csrf
                        <button class="btn btn-primary btn-sm">
                            Pedir Devolução
                        </button>
                    </form>
                @endif

            @endif

            {{-- AÇÕES ADMINISTRATIVAS --}}
            @if(auth()->user()->role === 'admin')

                @if($requisicao->estado === 'pendente')
                    <form method="POST" action="{{ route('requisicoes.confirmar', $requisicao) }}">
                        @csrf
                        <button class="btn btn-success btn-sm">
                            Confirmar
                        </button>
                    </form>

                    <form method="POST" action="{{ route('requisicoes.negar', $requisicao) }}">
                        @csrf
                        <button class="btn btn-error btn-sm">
                            Negar
                        </button>
                    </form>
                @endif

                @if($requisicao->estado === 'devolucao_pedida')
                    <form method="POST"
                          action="{{ route('requisicoes.aceitarDevolucao', $requisicao) }}">
                        @csrf
                        <button class="btn btn-warning btn-sm">
                            Aceitar Devolução
                        </button>
                    </form>
                @endif

            @endif
        </div>

        {{-- Fallback --}}
        @if(
            !(
                (auth()->id() === $requisicao->user_id && in_array($requisicao->estado, ['pendente','confirmado']))
                ||
                (auth()->user()->role === 'admin' && in_array($requisicao->estado, ['pendente','devolucao_pedida']))
            )
        )
            <p class="text-sm text-gray-500 mt-3">
                Não existem ações disponíveis para esta requisição.
            </p>
        @endif
    </div>

    {{-- REVIEW --}}
    @if(
        auth()->id() === $requisicao->user_id &&
        $requisicao->estado === 'entregue' &&
        ! $requisicao->review
    )
        <div class="card bg-base-100 shadow p-6">
            <h3 class="font-bold text-lg mb-4">Avaliar Livro</h3>

            <form method="POST"
                  action="{{ route('reviews.store', $requisicao) }}"
                  class="space-y-4">
                @csrf

                <div>
                    <label class="label">
                        <span class="label-text">Comentário</span>
                    </label>
                    <textarea
                        name="comentario"
                        class="textarea textarea-bordered w-full"
                        rows="4"
                        required
                    ></textarea>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text">Classificação</span>
                    </label>
                    <select name="rating" class="select select-bordered w-full">
                        <option value="">Sem classificação</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>
                </div>

                <div class="flex justify-end">
                    <button class="btn btn-primary btn-sm">
                        Enviar Review
                    </button>
                </div>
            </form>
        </div>
    @endif

    

    {{-- REVIEW EXISTENTE --}}
@if($requisicao->review)
    <div class="card bg-base-100 shadow p-6">
        <h3 class="font-bold text-lg mb-2">Review</h3>

        <p class="text-sm text-gray-500 mb-2">
            Estado:
            <span class="badge
                @if($requisicao->review->estado === 'pendente') badge-warning
                @elseif($requisicao->review->estado === 'ativa') badge-success
                @else badge-error
                @endif">
                {{ ucfirst($requisicao->review->estado) }}
            </span>
        </p>

        <p class="mb-2">
            {{ $requisicao->review->comentario }}
        </p>

        @if($requisicao->review->rating)
            <p class="text-sm">
                Classificação:
                <strong>{{ $requisicao->review->rating }} ⭐</strong>
            </p>
        @endif

        @if(
            $requisicao->review->estado === 'recusada' &&
            $requisicao->review->justificacao &&
            auth()->user()->role === 'admin'
        )
            <div class="mt-3 text-sm text-error">
                <strong>Justificação:</strong>
                {{ $requisicao->review->justificacao }}
            </div>
        @endif
    </div>
@endif


</div>
@endsection
