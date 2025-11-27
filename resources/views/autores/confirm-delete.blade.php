<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apagar Autor') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">

            <h3 class="text-lg font-semibold text-red-600 mb-4">
                Tens a certeza que queres apagar este autor?
            </h3>

            <div class="mb-4">
                <p><span class="font-semibold">ID:</span> {{ $autor->id }}</p>
                <p><span class="font-semibold">Nome:</span> {{ $autor->nome }}</p>
                <p>Foto:</p>
                    @if($autor->foto)
                    <img src="{{ asset('storage/' . $autor->foto) }}" width="120">
                    @endif
                @isset($autor->nacionalidade)
                    <p><span class="font-semibold">Nacionalidade:</span> {{ $autor->nacionalidade }}</p>
                @endisset
                @isset($autor->data_nascimento)
                    <p><span class="font-semibold">Data Nascimento:</span> {{ $autor->data_nascimento }}</p>
                @endisset
            </div>

            <div class="flex items-center gap-4 mt-6">
                {{-- Cancelar: volta à lista --}}
                <a href="{{ route('autores.index') }}"
                   class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancelar
                </a>

                {{-- Apagar definitivamente --}}
                <form action="{{ route('autores.destroy', $autor) }}" method="POST"
                      onsubmit="return confirm('Apagar mesmo este autor?');">
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
