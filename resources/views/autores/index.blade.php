@extends('layouts.default')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Autores</h1>

    <a href="{{ route('autores.create') }}" class="btn btn-primary">
        + Novo Autor
    </a>
</div>

<div class="overflow-x-auto bg-base-100 shadow rounded">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Livros</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($autores as $autor)
                <tr>
                    <td>
                        <img class="w-12 h-12 rounded-full object-cover"
                             src="{{ $autor->foto
                                ? asset('storage/'.$autor->foto)
                                : 'https://ui-avatars.com/api/?name='.urlencode($autor->nome) }}">
                    </td>
                    <td>{{ $autor->nome }}</td>
                    <td>{{ $autor->livros_count }}</td>
                    <td class="flex gap-2">
                        <a href="{{ route('autores.show', $autor) }}" class="btn btn-sm">
                            Ver
                        </a>

                        <a href="{{ route('autores.edit', $autor) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form method="POST" action="{{ route('autores.destroy', $autor) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-error"
                                    onclick="return confirm('Eliminar autor?')">
                                Apagar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $autores->links() }}
</div>

@endsection
