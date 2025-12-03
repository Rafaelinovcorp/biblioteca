<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Criar Livro
        </h2>
    </x-slot>

    <div class="py-6 mx-auto sm:px-6 lg:px-8 w-full">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Erro!</strong> Verifica os campos abaixo.
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('livros.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Nome --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome do livro</label>
                    <input type="text"
                           name="nome"
                           value="{{ old('nome') }}"
                           required
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                    @error('nome') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- ISBN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                    <input type="text"
                           name="isbn"
                           value="{{ old('isbn') }}"
                           required
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                    @error('isbn') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Ano e Preço --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                        <input type="number"
                               name="ano"
                               value="{{ old('ano') }}"
                               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        @error('ano') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preço (€)</label>
                        <input type="number"
                               step="0.01"
                               min="0"
                               name="preco"
                               value="{{ old('preco') }}"
                               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        @error('preco') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Editora --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Editora</label>
                    <select name="editora_id"
                            required
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Selecionar Editora --</option>
                        @foreach ($editoras as $editora)
                            <option value="{{ $editora->id }}" {{ old('editora_id') == $editora->id ? 'selected' : '' }}>
                                {{ $editora->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('editora_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Autores (multiselect) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Autores</label>

                    <select name="autores[]" multiple
                            required
                            class="w-full border rounded px-3 py-2 h-40 focus:ring-2 focus:ring-blue-200">
                        @foreach ($autores as $autor)
                            <option value="{{ $autor->id }}" {{ in_array($autor->id, old('autores', [])) ? 'selected' : '' }}>
                                {{ $autor->nome }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-gray-500 text-sm mt-1">* Seleciona um ou vários autores</p>
                    @error('autores') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Upload de PDF --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ficheiro PDF do livro (opcional)</label>
                    <input type="file"
                           name="pdf"
                           accept="application/pdf"
                           class="w-full border rounded px-3 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-200">

                    <p class="text-gray-500 text-sm mt-1">Apenas PDF. Máx: 10MB.</p>

                    @error('pdf') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Botões --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('livros.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Guardar Livro
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
