@extends('layouts.app')

@section('title', 'Editar Autor')

@section('content')
<h1 class="text-2xl font-bold mb-4">Editar Autor</h1>

<form action="/autores/{{ $autor->id }}" method="POST">
    @csrf
    @method('PUT')

    <label class="block mb-2">Nome</label>
    <input type="text" name="nome" class="border p-2 w-full" value="{{ $autor->nome }}" required>

    <button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
        Atualizar
    </button>
</form>
@endsection
