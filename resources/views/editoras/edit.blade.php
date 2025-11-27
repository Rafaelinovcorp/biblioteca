<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Editora
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <form action="{{ route('editoras.update', $editora) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2">Nome</label>
                    <input type="text" name="nome"
                           value="{{ old('nome', $editora->nome) }}"
                           class="w-full border-gray-300 rounded" required>
                </div>

                <div class="mt-4">
                    <label class="block mb-2">Logotipo atual</label>
                    @if ($editora->logotipo)
                        <img src="{{ asset('storage/' . $editora->logotipo) }}"
                             class="w-24 h-24 rounded-full object-cover">
                    @else
                        <p class="text-gray-400 text-sm">Sem logotipo.</p>
                    @endif
                </div>

                <div class="mt-2">
                    <label class="block mb-2">Alterar logotipo</label>
                    <input type="file" name="logotipo"
                           class="block w-full text-sm text-gray-700">
                </div>

                <button class="mt-4 bg-blue-600 text-black px-4 py-2 rounded">
                    Atualizar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
