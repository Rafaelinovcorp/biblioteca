@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">
        {{ $editora->nome }}
    </h2>
@endsection

@section('content')
    <div class="p-6 max-w-3xl">
        <div class="flex gap-6 items-start">

            <img class="w-32 h-32 object-contain"
                 src="{{ $editora->logotipo
                    ? Storage::url($editora->logotipo)
                    : 'https://via.placeholder.com/150?text=Editora' }}"
                 alt="Logótipo {{ $editora->nome }}">

            <div class="space-y-4">
                <div>
                    <h3 class="font-bold mb-2">Livros desta editora</h3>
                    <ul class="list-disc ml-6">
                        @forelse($editora->livros as $livro)
                            <li>{{ $livro->nome }}</li>
                        @empty
                            <li class="text-gray-500">
                                Sem livros associados.
                            </li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
