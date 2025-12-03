<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Apagar Livro
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <h3 class="text-lg font-semibold mb-4 text-red-600">
                Tens a certeza que queres apagar este livro?
            </h3>

            <div class="mb-4 border rounded p-4 bg-gray-50">
                <p><strong>Título:</strong> {{ $livro->titulo }}</p>
                <p><strong>Autor:</strong> {{ $livro->autor?->nome }}</p>
                <p><strong>Editora:</strong> {{ $livro->editora?->nome }}</p>
                <p><strong>Ano:</strong> {{ $livro->ano ?? '-' }}</p>
                <p><strong>Preço:</strong>
                    @if (!is_null($livro->preco))
                        {{ number_format($livro->preco, 2, ',', ' ') }} €
                    @else
                        -
                    @endif
                </p>
            </div>

            <form action="{{ route('livros.destroy', $livro) }}" method="POST" class="flex justify-end">
                @csrf
                @method('DELETE')

                <a href="{{ route('livros.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded mr-2">
                    Cancelar
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Apagar
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
