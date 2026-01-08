@extends('layouts.default')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        ✏️ Editar Livro
    </h1>

    <form method="POST"
          action="{{ route('livros.update', $livro) }}"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')

        {{-- Nome --}}
        <div>
            <label class="label">
                <span class="label-text">Nome</span>
            </label>
            <input type="text"
                   name="nome"
                   value="{{ old('nome', $livro->nome) }}"
                   class="input input-bordered w-full"
                   required>
        </div>

        {{-- ISBN --}}
        <div>
            <label class="label">
                <span class="label-text">ISBN</span>
            </label>
            <input type="text"
                   name="isbn"
                   value="{{ old('isbn', $livro->isbn) }}"
                   class="input input-bordered w-full">
        </div>
        {{-- Biografia --}}
<div>
    <label class="label">
        <span class="label-text">Biografia / Descrição</span>
    </label>

    <textarea name="bibliografia"
              rows="6"
              class="textarea textarea-bordered w-full">{{ old('bibliografia', $livro->bibliografia) }}</textarea>
</div>


        {{-- Editora --}}
        <div>
            <label class="label">
                <span class="label-text">Editora</span>
            </label>
            <select name="editora_id class="select w-full"
                    class="select select-bordered w-full"
                    required>
                @foreach($editoras as $editora)
                    <option value="{{ $editora->id }}"
                        @selected(old('editora_id', $livro->editora_id) == $editora->id)>
                        {{ $editora->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Autores --}}
        <div>
            <label class="label">
                <span class="label-text">Autores</span>
            </label>
            <select name="autores[]"
                    multiple
                    class="select select-bordered w-full min-h-[120px]">
                @foreach($autores as $autor)
                    <option value="{{ $autor->id }}"
                        @selected(
                            in_array(
                                $autor->id,
                                old('autores', $livro->autores->pluck('id')->toArray())
                            )
                        )>
                        {{ $autor->nome }}
                    </option>
                @endforeach
            </select>
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

        {{-- Preço --}}
        <div>
            <label class="label">
                <span class="label-text">Preço (€)</span>
            </label>
            <input type="number"
                   name="preco"
                   step="0.01"
                   min="0"
                   value="{{ old('preco', $livro->preco) }}"
                   class="input input-bordered w-full"
                   required>
        </div>

        {{-- Estado --}}
        <div>
            <label class="label">
                <span class="label-text">Estado</span>
            </label>
            <select name="estado"
                    class="select select-bordered w-full"
                    required>
                <option value="disponivel"
                    @selected(old('estado', $livro->estado) === 'disponivel')>
                    Disponível
                </option>
                <option value="requisitado"
                    @selected(old('estado', $livro->estado) === 'requisitado')>
                    Requisitado
                </option>
            </select>
        </div>

        {{-- Capa --}}
        <div>
            <label class="label">
                <span class="label-text">Capa</span>
            </label>
            <input type="file"
                   name="capa"
                   class="file-input file-input-bordered w-full">

            @if($livro->capa)
                <img src="{{ asset('storage/'.$livro->capa) }}"
                     class="mt-2 w-32 rounded shadow">
            @endif
        </div>

        {{-- PDF --}}
        <div>
            <label class="label">
                <span class="label-text">PDF</span>
            </label>
            <input type="file"
                   name="pdf"
                   class="file-input file-input-bordered w-full">

            @if($livro->pdf)
                <p class="mt-2">
                    <a href="{{ asset('storage/'.$livro->pdf) }}"
                       class="link"
                       target="_blank">
                        📄 Ver PDF atual
                    </a>
                </p>
            @endif
        </div>

        {{-- BOTÕES --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('livros.show', $livro) }}"
               class="btn btn-ghost">
                Cancelar
            </a>

            <button type="submit"
                    class="btn btn-primary">
                Guardar Alterações
            </button>
        </div>

    </form>

</div>

@endsection
