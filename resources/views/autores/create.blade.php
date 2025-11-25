@extends('layouts.app')

@section('title', 'Criar Autor')

@section('content')
<h1 class="text-2xl font-bold mb-4">Criar Autor</h1>

<form action="/autores" method="POST">
    @csrf

    <label class="block mb-2">Nome</label>
    <input type="text" name="nome" class="border p-2 w-full" required>

    <button class="bg-green-600 text-white px-4 py-2 rounded mt-4">
        Guardar
    </button>
</form>
@endsection
