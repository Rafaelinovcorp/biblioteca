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

                <div>
                    <label class="block mb-2">Nome</label>
                    <input type="text" name="nome"
                           value="{{ old('nome') }}"
                           class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mt-4">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto do Autor</label>
                    <input
                        id="foto"
                        name="foto"
                        type="file"
                        class="mt-1 block w-full text-sm text-gray-700
                               border-gray-300 rounded-md shadow-sm
                               focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>


                <button class="mt-4 bg-green-600 text-black px-4 py-2 rounded">
                    Guardar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
