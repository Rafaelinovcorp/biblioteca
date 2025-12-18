@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">
        Google Books API
    </h2>
@endsection

@section('content')


        <div class="p-6 space-y-6">

            {{-- Pesquisa --}}
            <form method="POST"
                  action="{{ route('google-books.search') }}"
                  class="flex gap-2">
                @csrf

                <input name="q"
                       value="{{ $query ?? '' }}"
                       class="input input-bordered w-full"
                       placeholder="Pesquisar por título, autor ou ISBN"
                       required>

                <button class="btn btn-primary">
                    Pesquisar
                </button>
            </form>

            {{-- Resultados --}}
            @isset($results)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($results as $volumeId => $item)
                        @php
                            $info = $item['volumeInfo'] ?? [];
                        @endphp

                        <div class="card bg-base-100 shadow p-4 space-y-2">
                            <h3 class="font-bold">
                                {{ $info['title'] ?? 'Sem título' }}
                            </h3>

                            <p class="text-sm text-gray-600">
                                {{ implode(', ', $info['authors'] ?? []) }}
                            </p>

                            @if(isset($info['imageLinks']['thumbnail']))
                                <img class="w-32 mt-2"
                                     src="{{ $info['imageLinks']['thumbnail'] }}"
                                     alt="Capa do livro">
                            @endif

                            <form method="POST"
                                  action="{{ route('google-books.import', $volumeId) }}"
                                  class="pt-2">
                                @csrf

                                <button class="btn btn-success btn-sm">
                                    Importar
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500">
                            Nenhum resultado encontrado.
                        </p>
                    @endforelse
                </div>
            @endisset

        </div>

@endsection
