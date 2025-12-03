<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editoras') }}
            </h2>

            <a href="{{ route('editoras.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded shadow hover:bg-blue-700">
                + Criar Editora
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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



            {{-- FILTROS / PESQUISA --}}
            <form method="GET" action="{{ route('editoras.index') }}" class="mb-4 flex items-center gap-2">
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

                <a href="{{ route('editoras.index') }}"
   class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
    Limpar
</a>

                @if(request()->filled('nome'))
                    <a href="{{ route('editoras.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Limpar
                    </a>
                @endif
            </form>

            {{-- TABELA DE EDITORAS --}}
            <table class="w-full bg-white shadow rounded">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="p-3 text-left">Nome</th>
                        <th class="p-3 text-center">Ações</th>
                        <th class="p-3 text-center">Logotipo</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($editoras as $editora)
                        <tr class="border-b">
                            <td class="p-3">{{ $editora->nome }}</td>

                            <td class="p-3 text-center">
                                <a href="{{ route('editoras.edit', $editora) }}" class="text-blue-600 px-2 hover:underline">
                                    Editar
                                </a>

                                <a href="{{ route('editoras.confirm-delete', $editora) }}"
                                   class="text-red-600 px-2 hover:underline">
                                    Apagar
                                </a>
                            </td>

                            <td class="p-3 text-center">
                                @if ($editora->logotipo)
                                    <img src="{{ asset('storage/' . $editora->logotipo) }}"
                                         alt="{{ $editora->nome }}"
                                         class="w-12 h-12 rounded-full object-cover mx-auto">
                                @else
                                    <span class="text-gray-400 text-sm">Sem logotipo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-3 text-center text-gray-500">
                                Nenhuma editora encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $editoras->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
