<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Editora
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <form action="{{ route('editoras.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div>
                    <label class="block mb-2">Nome</label>
                    <input type="text" name="nome"
                           class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mt-4">
                    <label class="block mb-2">Logotipo</label>
                    <input type="file" name="logotipo"
                           class="block w-full text-sm text-gray-700">
                </div>

                <button class="mt-4 bg-blue-600 text-black  px-4 py-2 rounded">
                    Guardar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
