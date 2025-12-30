@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Confirmar importação
    </h2>

<h3 class="font-semibold text-lg mb-2">
    {{ $volume['volumeInfo']['title'] ?? 'Sem título' }}
</h3>

<p class="text-sm mb-2">
    <strong>Autores:</strong>
    {{ implode(', ', $volume['volumeInfo']['authors'] ?? ['Desconhecido']) }}
</p>

<div class="mb-4">
    <strong>Biografia:</strong>
    <p class="text-sm mt-1 whitespace-pre-line">
        {{ $volume['volumeInfo']['description'] ?? 'Sem descrição.' }}
    </p>
</div>


    <form method="POST"
          action="{{ route('google-books.store', $volumeId) }}">
        @csrf

        <label class="block mb-2 font-semibold">
            Categoria
        </label>

        <select name="categoria_id" required class="border rounded w-full p-2 mb-4">
            <option value="">-- Selecionar categoria --</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Confirmar importação
        </button>
    </form>

</div>
@endsection
