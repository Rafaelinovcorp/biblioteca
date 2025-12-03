<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Autor
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <form action="{{ route('autores.update', $autor) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Nome --}}
                <div class="mb-4">
                    <label class="block mb-2 font-semibold">Nome</label>
                    <input type="text"
                           name="nome"
                           value="{{ old('nome', $autor->nome) }}"
                           class="w-full border-gray-300 rounded px-3 py-2"
                           required>
                </div>

                {{-- Avatar atual + upload --}}
                <div class="mb-4 flex items-center gap-6">
                    {{-- Avatar preview --}}
                    <div class="avatar">
                        <div class="w-20 h-20 rounded-full overflow-hidden">
                            <img
                                src="{{ $autor->foto
                                    ? asset('storage/' . $autor->foto)
                                    : asset('storage/autores/default-avatar.jpg') }}"
                                alt="{{ $autor->nome }}"
                                class="object-cover w-full h-full"
                            >
                        </div>
                    </div>

                    {{-- Input de nova foto --}}
                    <div>
                        <label class="block mb-2 font-semibold">Foto (avatar)</label>
                        <input type="file"
                               name="foto"
                               class="file-input file-input-bordered w-full max-w-xs">
                        <p class="text-xs text-gray-500 mt-1">
                            Se escolheres um ficheiro, a foto antiga será substituída.
                        </p>
                        @error('foto')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-4 bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 transition"
                >
                    Atualizar
                </button>

                <a href="{{ route('autores.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">
                Voltar à lista
            </a>
            </form>
        </div>
    </div>
</x-app-layout>
