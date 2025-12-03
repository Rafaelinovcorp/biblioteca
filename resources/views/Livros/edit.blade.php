<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Livro
        </h2>
    </x-slot>

    <div class="py-6 mx-auto sm:px-6 lg:px-8 max-w-4xl">
        <div class="bg-white p-6 shadow rounded">

            <form action="{{ route('livros.update', $livro) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">

                @csrf
                @method('PUT')

                {{-- Nome --}}
                <div>
                    <label class="block mb-1 font-semibold">Nome / Título</label>
                    <input type="text" name="nome"
                           value="{{ old('nome', $livro->nome) }}"
                           required
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                    @error('nome')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ISBN --}}
                <div>
                    <label class="block mb-1 font-semibold">ISBN</label>
                    <input type="text" name="isbn"
                           value="{{ old('isbn', $livro->isbn) }}"
                           required
                           class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                    @error('isbn')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ano + Preço --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1">Ano</label>
                        <input type="number" name="ano"
                               value="{{ old('ano', $livro->ano) }}"
                               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        @error('ano')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Preço (€)</label>
                        <input type="number" step="0.01" name="preco"
                               value="{{ old('preco', $livro->preco) }}"
                               class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        @error('preco')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Editora --}}
                <div>
                    <label class="block mb-1">Editora</label>
                    <select name="editora_id"
                            required
                            class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Selecionar Editora --</option>
                        @foreach ($editoras as $editora)
                            <option value="{{ $editora->id }}"
                                {{ old('editora_id', $livro->editora_id) == $editora->id ? 'selected' : '' }}>
                                {{ $editora->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('editora_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Autores (multiselect pivot) --}}
                <div>
                    <label class="block mb-1">Autores</label>

                    <select name="autores[]" multiple
                            required
                            class="w-full border rounded px-3 py-2 h-40 focus:ring-2 focus:ring-blue-200">

                        @foreach ($autores as $autor)
                            <option value="{{ $autor->id }}"
                                {{ in_array($autor->id, old('autores', $livro->autores->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $autor->nome }}
                            </option>
                        @endforeach
                    </select>

                    <p class="text-gray-500 text-sm mt-1">* Selecione um ou vários autores</p>

                    @error('autores')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload / Substituir PDF --}}
                <div>
                    <label class="block mb-1 font-semibold">PDF do Livro</label>

                    {{-- Se já existe PDF, mostrar link para download --}}
                    @if($livro->pdf_path)
                        <div class="mb-2 flex items-center gap-3">
                            <a href="{{ route('livros.download', $livro) }}"
                               class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                Baixar PDF atual
                            </a>

                            <span class="text-gray-600 text-sm">
                                (ficheiro atual: {{ basename($livro->pdf_path) }})
                            </span>
                        </div>
                    @endif

                    <input type="file" name="pdf" accept="application/pdf"
                           class="w-full border rounded px-3 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-200">

                    <p class="text-gray-500 text-sm mt-1">Apenas PDF. Máx: 10MB.</p>

                    @error('pdf')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botões --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('livros.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                        Guardar alterações
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
