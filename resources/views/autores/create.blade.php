<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Autor
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <form action="{{ route('autores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nome --}}
                <div>
                    <label class="block mb-2 font-semibold">Nome</label>
                    <input type="text"
                           name="nome"
                           value="{{ old('nome') }}"
                           class="w-full border-gray-300 rounded px-3 py-2"
                           required>
                </div>

                {{-- Avatar preview + upload --}}
                <div class="mt-4 flex items-center gap-4">
                    <div class="avatar">
                        <div class="w-20 h-20 rounded-full overflow-hidden">
                            <img
                                src="{{ asset('storage/autores/default-avatar.jpg') }}"
                                alt="Avatar padrão"
                                class="w-full h-full object-cover"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 font-semibold">Foto (avatar)</label>
                        <input type="file"
                               name="foto"
                               class="file-input file-input-bordered w-full max-w-xs">

                        @error('foto')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button class="mt-6 bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 transition">
                    Guardar
                </button>
                
                <a href="{{ route('autores.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">
                Voltar à lista
            </a>
            </form>
        </div>
    </div>
</x-app-layout>
