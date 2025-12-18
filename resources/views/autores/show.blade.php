<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ $autor->nome }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl">
        <div class="flex gap-6 items-start">

            <img class="w-32 h-32 rounded-full object-cover"
                 src="{{ $autor->foto
                    ? asset('storage/'.$autor->foto)
                    : 'https://ui-avatars.com/api/?name='.$autor->nome }}">

            <div class="space-y-4">
                <p>{{ $autor->bibliografia }}</p>

                <div>
                    <h3 class="font-bold mb-2">Livros</h3>
                    <ul class="list-disc ml-6">
                        @forelse($autor->livros as $livro)
                            <li>{{ $livro->nome }}</li>
                        @empty
                            <li class="text-gray-500">
                                Sem livros associados.
                            </li>
                        @endforelse
                    </ul>
                </div>

                @can('admin')
                    <div class="flex gap-2 pt-4">
                        <a href="{{ route('autores.edit', $autor) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
