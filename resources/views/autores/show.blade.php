@extends('layouts.app')

@section('title', 'Detalhes do Autor')

@section('content')
<h1 class="text-2xl font-bold mb-4">Autor: {{ $autor->nome }}</h1>

<p><strong>ID:</strong> {{ $autor->id }}</p>
<p><strong>Nome:</strong> {{ $autor->nome }}</p>

<a href="/autores" class="text-blue-600 mt-4 inline-block">Voltar</a>
@endsection
