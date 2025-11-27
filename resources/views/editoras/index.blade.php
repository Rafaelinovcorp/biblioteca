<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editoras') }}
            </h2>

            <a href="{{ route('editoras.create') }}"
               class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                + Criar Editora
            </a>
        </div>
    </x-slot>


    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <table class="w-full bg-white shadow rounded">
                <thead>
                    <tr class="border-b">
                        <th class="p-3 text-left">Nome</th>
                        <th class="p-3 text-center">Ações</th>
                        <th class="p-3 text-center">Logotipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($editoras as $editora)
                        <tr class="border-b">
                            <td class="p-3">{{ $editora->nome }}</td>

                            <td class="p-3 text-center">
                                {{-- Se quiseres, mais tarde fazemos view/confirm-delete etc. --}}
                                <a href="{{ route('editoras.edit', $editora) }}" class="text-blue-600 ml-2">
                                    Editar
                                </a>
                                <form action="{{ route('editoras.destroy', $editora) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                <a href="{{ route('editoras.confirm-delete', $editora) }}"
                                   class="text-red-600 ml-2 px-2">
                                    Apagar
                                </a>

                                </form>
                            </td>

                            <td class="p-3 text-center">
                                @if ($editora->logotipo)
                                    <img src="{{ asset('storage/' . $editora->logotipo) }}"
                                         class="w-12 h-12 rounded-full object-cover mx-auto">
                                @else
                                    <span class="text-gray-400 text-sm">Sem logotipo</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
