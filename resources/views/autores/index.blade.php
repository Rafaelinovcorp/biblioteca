<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Autores') }}
            </h2>
    
            <a href="{{ route('autores.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                + Criar Autor
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <table class="w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Nome</th>
                        <th class="p-3">Ações</th>
                        <th class="p-3">Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($autores as $autor)
                        <tr class="border-b">
                            <td class="p-3">{{ $autor->nome }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ route('autores.show', $autor) }}" class="text-green-600 px-2">Ver</a>
                                <a href="{{ route('autores.edit', $autor) }}" class="text-blue-600 ml-2 px-2">Editar</a>
                                <a href="{{ route('autores.confirm-delete', $autor) }}"
                                   class="text-red-600 ml-2 px-2">
                                    Apagar
                                </a>
                            </td>
                            <td class="p-3 text-center">
                                @if ($autor->foto)
                                    <img src="{{ asset('storage/' . $autor->foto) }}"
                                         class="w-12 h-12 rounded-full object-cover mx-auto">
                                @else
                                    <span class="text-gray-400 text-sm">Sem foto</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
