@extends('layouts.default')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">📚 Catálogo de Livros</h1>

@if(auth()->check() && auth()->user()->role === 'admin')
    <a href="{{ route('livros.create') }}" class="btn btn-primary btn-sm">
        + Novo Livro
    </a>
@endif


</div>

<div class="overflow-x-auto bg-base-100 rounded shadow">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Nome</th>
                <th>ISBN</th>
                <th>Editora</th>
                <th>Estado</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($livros as $livro)
                <tr>
                    <td>{{ $livro->nome }}</td>
                    <td>{{ $livro->isbn }}</td>
                    <td>{{ $livro->editora->nome ?? '-' }}</td>
                    <td>
                        <span class="badge badge-success">Disponível</span>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('livros.show', $livro) }}" class="btn btn-xs btn-outline">
                            Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
