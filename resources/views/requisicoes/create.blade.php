@extends('layouts.default')

@section('header')
    <h2 class="font-semibold text-xl">Nova Requisição</h2>
@endsection

@section('content')
    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('requisicoes.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="label">Livro disponível</label>
                <select name="livro_id" class="select select-bordered w-full" required>
                    @foreach($livros as $l)
                        <option value="{{ $l->id }}">
                            {{ $l->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            @error('livro_id')
                <p class="text-error text-sm">{{ $message }}</p>
            @enderror

            <div class="flex justify-end">
                <button class="btn btn-primary">
                    Requisitar
                </button>
            </div>
        </form>
    </div>
@endsection
