<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Autor
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded py-5">
            <p><strong>ID:</strong> {{ $autor->id }}</p>
            <p class="mt-2"><strong>Nome:</strong> {{ $autor->nome }}</p>

            <p>Foto:</p>
            @if($autor->foto)
            <img src="{{ asset('storage/' . $autor->foto) }}" width="120">
            @endif


            <a href="{{ route('autores.index') }}" class="mt-4 inline-block text-blue-600">
                Voltar à lista
            </a>
        </div>
    </div>
</x-app-layout>
