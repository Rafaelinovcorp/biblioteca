<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de Livros</h2>

            <a href="{{ route('livros.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded shadow hover:bg-blue-700">
                + Novo Livro
            </a>
        </div>
    </x-slot>

    <div class="py-6 mx-auto sm:px-6 lg:px-8 w-full">

        {{-- Mensagem de sucesso --}}
        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTROS --}}
        <form method="GET" action="{{ route('livros.index') }}"
              class="mb-4 bg-white p-4 rounded shadow flex flex-row flex-nowrap items-center gap-4 overflow-x-auto">

            
            <div class="flex-1 min-w-[220px]">
                <input
                    aria-label="Nome do livro"
                    type="text"
                    name="nome"
                    value="{{ request('nome') }}"
                    placeholder="Nome do livro"
                    class="w-full border rounded px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >
            </div>

            <div class="flex-1 min-w-[200px]">
                <select aria-label="Autor" name="autor_id"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Autor (Todos)</option>
                    @foreach($autores ?? [] as $autor)
                        <option value="{{ $autor->id }}" {{ request('autor_id') == $autor->id ? 'selected' : '' }}>
                            {{ $autor->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <select aria-label="Editora" name="editora_id"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Editora (Todas)</option>
                    @foreach($editoras as $editora)
                        <option value="{{ $editora->id }}" {{ request('editora_id') == $editora->id ? 'selected' : '' }}>
                            {{ $editora->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[140px]">
                <input aria-label="Preço mínimo" type="number" name="preco_min" value="{{ request('preco_min') }}"
                       placeholder="Preço min" step="0.01" min="0"
                       class="w-full border rounded px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>

            <div class="flex-1 min-w-[140px]">
                <input aria-label="Preço máximo" type="number" name="preco_max" value="{{ request('preco_max') }}"
                       placeholder="Preço max" step="0.01" min="0"
                       class="w-full border rounded px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
            </div>

            <div class="flex-1 min-w-[160px]">
                <select aria-label="Ordenar por preço" name="preco_order"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Ordenar por preço</option>
                    <option value="asc"  {{ request('preco_order') == 'asc'  ? 'selected' : '' }}>Menor → Maior</option>
                    <option value="desc" {{ request('preco_order') == 'desc' ? 'selected' : '' }}>Maior → Menor</option>
                </select>
            </div>

            {{-- Botões finais --}}
            <div class="flex items-center gap-2 min-w-[160px]">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-black rounded shadow hover:bg-blue-700">
                    Filtrar
                </button>

                <a href="{{ route('livros.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    Limpar
                </a>
            </div>
        </form>

        {{-- TABELA --}}
        <div class="bg-white overflow-hidden shadow rounded w-full">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 border-b text-left">Título</th>
                        <th class="px-4 py-3 border-b text-left">Autor(es)</th>
                        <th class="px-4 py-3 border-b text-left">Editora</th>
                        <th class="px-4 py-3 border-b text-left">Ano</th>
                        <th class="px-4 py-3 border-b text-left">Preço</th>
                        <th class="px-4 py-3 border-b text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($livros as $livro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b">{{ $livro->nome }}</td>

                            <td class="px-4 py-3 border-b">
                                @if ($livro->autores->isNotEmpty())
                                    {{ $livro->autores->pluck('nome')->join(', ') }}
                                @else
                                    <span class="text-gray-400">Sem autores</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 border-b">{{ $livro->editora?->nome }}</td>

                            <td class="px-4 py-3 border-b">{{ $livro->ano ?? '-' }}</td>

                            <td class="px-4 py-3 border-b">
                                @if($livro->preco !== null)
                                    {{ number_format($livro->preco, 2, ',', ' ') }} €
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-4 py-3 border-b text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <a href="{{ route('livros.edit', $livro) }}"
                                       class="px-3 py-1 text-sm bg-yellow-400 text-black rounded hover:bg-yellow-500">
                                        Editar
                                    </a>

                                    <form action="{{ route('livros.destroy', $livro) }}" method="POST"
                                          onsubmit="return confirm('Confirmar eliminação?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                                            Apagar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                Ainda não existem livros registados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        <div class="mt-4">
            {{ $livros->links() }}
        </div>
    </div>
</x-app-layout>
