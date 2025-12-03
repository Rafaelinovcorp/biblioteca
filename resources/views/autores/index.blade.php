<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Autores') }}
            </h2>

            <a href="{{ route('autores.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded shadow hover:bg-blue-700">
                + Criar Autor
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros / Pesquisa --}}
            <form method="GET" action="{{ route('autores.index') }}" class="mb-4 flex items-center gap-2">
                <input
                    type="text"
                    name="nome"
                    value="{{ request('nome') }}"
                    placeholder="Pesquisar por nome..."
                    class="border rounded px-3 py-2 w-full sm:w-64"
                >

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                    Filtrar
                </button>

                <a href="{{ route('autores.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                     Limpar
                </a>

            </form>

            {{-- MENSAGENS --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

             @if (session('error'))
                <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- TABELA FINAL --}}
            <table class="w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Nome</th>
                        <th class="p-3 text-center">Ações</th>
                        <th class="p-3 text-center">Foto</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($autores as $autor)
                        <tr class="border-b">

                            {{-- NOME --}}
                            <td class="p-3">
                                {{ $autor->nome }}
                            </td>

                            {{-- AÇÕES --}}
                            <td class="p-3 text-center">
                                <a href="{{ route('autores.show', $autor) }}" class="text-green-600 px-2 hover:underline">
                                    Ver
                                </a>
                                <a href="{{ route('autores.edit', $autor) }}" class="text-blue-600 px-2 hover:underline">
                                    Editar
                                </a>
                                <a href="{{ route('autores.confirm-delete', $autor) }}"
                                   class="text-red-600 px-2 hover:underline">
                                    Apagar
                                </a>
                            </td>

                            {{-- FOTO --}}
                            <td class="p-3 text-center">
                                @if ($autor->foto)
                                    <img src="{{ asset('storage/' . $autor->foto) }}"
                                         alt="{{ $autor->nome }}"
                                         class="w-12 h-12 rounded-full object-cover mx-auto">
                                @else
                                    <span class="text-gray-400 text-sm">Sem foto</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-3 text-center text-gray-500">
                                Nenhum autor encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $autores->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
