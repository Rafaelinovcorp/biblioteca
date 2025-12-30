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

{{-- FILTROS --}}
<form method="GET"
      class="mb-4 flex flex-wrap gap-3 items-end justify-end">

    {{-- Pesquisa --}}
    <div>
        <label class="label">
            <span class="label-text">Pesquisar</span>
        </label>
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Nome ou ISBN"
               class="input input-bordered input-sm w-52">
    </div>

    {{-- Editora --}}
    <div>
        <label class="label">
            <span class="label-text">Editora</span>
        </label>
        <select name="editora" class="select select-bordered select-sm w-48">
            <option value="" selected hidden>Todas</option>
            @foreach($editoras as $editora)
                <option value="{{ $editora->id }}"
                    @selected(request('editora') == $editora->id)>
                    {{ $editora->nome }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Estado --}}
    <div>
        <label class="label">
            <span class="label-text">Estado</span>
        </label>
        <select name="estado" class="select select-bordered select-sm w-40">
            <option value="" selected hidden>Todas</option>
            <option value="disponivel" @selected(request('estado') === 'disponivel')>
                Disponível
            </option>
            <option value="requisitado" @selected(request('estado') === 'requisitado')>
                Requisitado
            </option>
        </select>
    </div>

    {{-- Preço mínimo --}}
    <div>
        <label class="label">
            <span class="label-text">Preço min (€)</span>
        </label>
        <input type="number"
               step="0.01"
               name="preco_min"
               value="{{ request('preco_min') }}"
               class="input input-bordered input-sm w-32">
    </div>

    {{-- Preço máximo --}}
    <div>
        <label class="label">
            <span class="label-text">Preço máx (€)</span>
        </label>
        <input type="number"
               step="0.01"
               name="preco_max"
               value="{{ request('preco_max') }}"
               class="input input-bordered input-sm w-32">
    </div>

    {{-- Botões --}}
    <div class="flex gap-2">
        <button class="btn btn-sm btn-primary">
            Filtrar
        </button>

        <a href="{{ route('livros.index') }}"
           class="btn btn-sm btn-ghost">
            Limpar
        </a>
    </div>

</form>

{{-- TABELA --}}
<div class="overflow-x-auto bg-base-100 rounded shadow">
    <table class="table table-zebra w-full">
        <thead>
            <tr>
                <th>Nome</th>
                <th>ISBN</th>
                <th>Editora</th>
                <th>Estado</th>

                <th class="text-right">
                    <a href="{{ route('livros.index', array_merge(request()->all(), [
                        'sort' => 'preco',
                        'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                    ])) }}"
                       class="flex items-center gap-1 justify-end">
                        Preço
                        @if(request('sort') === 'preco')
                            {{ request('direction') === 'asc' ? '⬆️' : '⬇️' }}
                        @endif
                    </a>
                </th>

                <th class="text-right">Ações</th>
            </tr>
        </thead>

        <tbody>
            @forelse($livros as $livro)
                <tr>
                    <td>{{ $livro->nome }}</td>
                    <td>{{ $livro->isbn }}</td>
                    <td>{{ $livro->editora->nome ?? '-' }}</td>

                    <td>
                        @if($livro->isDisponivel())
                            <span class="badge badge-success">
                                Disponível
                            </span>
                        @else
                            <span class="badge badge-warning">
                                Requisitado
                            </span>
                        @endif
                    </td>

                    <td class="text-right">
                        {{ number_format($livro->preco, 2, ',', '.') }} €
                    </td>

                    <td class="text-right space-x-1">
                        <a href="{{ route('livros.show', $livro) }}"
                           class="btn btn-xs btn-outline">
                            Ver
                        </a>

                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <a href="{{ route('livros.edit', $livro) }}"
                               class="btn btn-xs btn-warning">
                                Editar
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"
                        class="text-center text-gray-500">
                        Nenhum livro encontrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINAÇÃO --}}
<div class="mt-4">
    {{ $livros->links() }}
</div>

@endsection
