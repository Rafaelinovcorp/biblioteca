@extends('layouts.default')

@section('header')
    <h2 class="font-semibold text-xl">Reviews Pendentes</h2>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @forelse($reviews as $review)
        <div class="card bg-base-100 shadow p-4 space-y-3">

            <div class="text-sm text-gray-500">
                Livro: <strong>{{ $review->livro->nome }}</strong><br>
                Utilizador: {{ $review->user->name }}
            </div>

            <p>{{ $review->comentario }}</p>

            @if($review->rating)
                <p>⭐ Classificação: {{ $review->rating }}/5</p>
            @endif

            <div class="flex gap-2">
                {{-- Aprovar --}}
                <form method="POST"
                      action="{{ route('reviews.aprovar', $review) }}">
                    @csrf
                    <button class="btn btn-success btn-sm">
                        Aprovar
                    </button>
                </form>

                {{-- Recusar --}}
                <form method="POST"
                      action="{{ route('reviews.recusar', $review) }}">
                    @csrf
                    <input type="text"
                           name="justificacao"
                           placeholder="Justificação"
                           class="input input-bordered input-sm"
                           required>

                    <button class="btn btn-error btn-sm">
                        Recusar
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500">
            Não existem reviews pendentes.
        </p>
    @endforelse

</div>
@endsection
