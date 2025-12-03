<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Apagar autor
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded text-center">

            <h3 class="text-lg font-semibold mb-4">
                Tens a certeza que queres apagar esta editora?
            </h3>

            <p class="text-gray-600 mb-6">
                <strong>Nome:</strong> {{ $autor->nome }}
            </p>

            {{-- Mostrar foto --}}
            @if ($autor->foto)
                <img src="{{ asset('storage/' . $autor->foto) }}"
                     class="w-24 h-24 rounded-full object-cover mx-auto mb-6">
            @else
                <p class="text-gray-400 mb-6">Sem foto</p>
            @endif

            <div class="flex justify-center gap-4">
                <a href="{{ route('autores.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Cancelar
                </a>

                <form action="{{ route('autores.destroy', $autor) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Apagar
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
