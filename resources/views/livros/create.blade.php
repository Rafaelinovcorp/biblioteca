@extends('layouts.default')

@section('content')

@if ($errors->any())
    <div class="alert alert-error mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
    <label class="label">
        <span class="label-text">Biografia / Descrição</span>
    </label>

    <textarea name="bibliografia"
              rows="5"
              class="textarea textarea-bordered w-full"
              placeholder="Descrição ou biografia do livro...">{{ old('bibliografia') }}</textarea>
</div>

    <div>
        <label>Categoria</label>
        <select name="categoria_id" required>
    @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}">
            {{ $categoria->nome }}
        </option>
    @endforeach
</select>

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
    <label class="label">
        <span class="label-text">Preço (€)</span>
    </label>

    <input type="number"
           name="preco"
           step="0.01"
           min="0"
           value="{{ old('preco', $livro->preco ?? '') }}"
           class="input input-bordered w-full"  
           required>
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
