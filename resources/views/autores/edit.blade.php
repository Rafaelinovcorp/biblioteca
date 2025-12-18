@can('admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Editar Autor</h2>
    </x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST"
              enctype="multipart/form-data"
              action="{{ route('autores.update', $autor) }}"
              class="space-y-4">

            @csrf
            @method('PUT')

            <div>
                <label class="label">Nome</label>
                <input name="nome"
                       value="{{ $autor->nome }}"
                       class="input input-bordered w-full"
                       required>
            </div>

            <div>
                <label class="label">Bibliografia</label>
                <textarea name="bibliografia"
                          class="textarea textarea-bordered w-full">{{ $autor->bibliografia }}</textarea>
            </div>

            <div>
                <label class="label">Foto</label>
                <input type="file"
                       name="foto"
                       class="file-input w-full">
            </div>

            <button class="btn btn-warning">
                Atualizar
            </button>
        </form>
    </div>
</x-app-layout>
@endcan
