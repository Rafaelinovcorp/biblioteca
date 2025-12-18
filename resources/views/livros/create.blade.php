@extends('layouts.default')

@section('content')
<h1 class="text-2xl font-bold mb-4">Novo Livro</h1>
<form method="POST" action="{{ route('livros.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
        <label class="block">Nome</label>
        <input name="nome" class="input input-bordered w-full" required>
    </div>
    <div>
        <label>ISBN</label>
        <input name="isbn" class="input input-bordered w-full">
    </div>
    <div>
        <label>Editora</label>
        <select name="editora_id" class="select w-full">
            @foreach($editoras as $e)
                <option value="{{ $e->id }}">{{ $e->nome }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Autores (Ctrl+click multi)</label>
        <select name="autores[]" multiple class="select w-full">
            @foreach($autores as $a)
                <option value="{{ $a->id }}">{{ $a->nome }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Capa</label>
        <input type="file" name="capa" accept="image/*">
    </div>
    <div>
        <label>PDF</label>
        <input type="file" name="pdf" accept="application/pdf">
    </div>
    <div>
        <button class="btn">Guardar</button>
    </div>
</form>
@endsection
