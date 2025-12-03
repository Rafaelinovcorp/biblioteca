<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Autor
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <p><strong>ID:</strong> {{ $autor->id }}</p>
            <p class="mt-2"><strong>Nome:</strong> {{ $autor->nome }}</p>

            <div class="mt-4 flex items-center gap-6">
                {{-- Avatar --}}
                <div class="avatar">
                    <div class="w-24 h-24 rounded-full overflow-hidden">
                        <img
                            src="{{ $autor->foto
                                ? asset('storage/' . $autor->foto)
                                : asset('storage/autores/default-avatar.jpg') }}"
                            alt="{{ $autor->nome }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>

                <div>
                    <h1 class="text-2xl font-bold">{{ $autor->nome }}</h1>
                    {{-- espaço para mais infos no futuro --}}
                </div>
            </div>

            <a href="{{ route('autores.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">
                Voltar à lista
            </a>
        </div>
    </div>
</x-app-layout>
