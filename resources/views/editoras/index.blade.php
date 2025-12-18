@extends('layouts.default')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Editoras</h2>

       
            <a href="{{ route('editoras.create') }}" class="btn btn-primary">
                + Nova Editora
            </a>
     
    </div>
@endsection

@section('content')


        <div class="p-6">

            <div class="overflow-x-auto bg-base-100 shadow rounded">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Logótipo</th>
                            <th>Nome</th>
                            <th>Livros</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($editoras as $editora)
                            <tr>
                                <td>
                                    <img
                                        src="{{ $editora->logotipo
                                            ? Storage::url($editora->logotipo)
                                            : 'https://via.placeholder.com/80x80?text=Editora' }}"
                                        class="w-16 h-16 object-contain"
                                        alt="Logótipo {{ $editora->nome }}"
                                    >
                                </td>

                                <td>{{ $editora->nome }}</td>
                                <td>{{ $editora->livros_count }}</td>

                                <td class="flex gap-2">
                                    <a href="{{ route('editoras.show', $editora) }}"
                                       class="btn btn-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('editoras.edit', $editora) }}"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('editoras.destroy', $editora) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-error"
                                                onclick="return confirm('Eliminar editora?')">
                                            Apagar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-6">
                                    Nenhuma editora registada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $editoras->links() }}
            </div>

        </div>


   
@endsection
