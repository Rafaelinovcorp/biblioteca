@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">Editar Editora</h2>
@endsection

@section('content')


        <div class="p-6 max-w-xl">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('editoras.update', $editora) }}"
                  class="space-y-4">

                @csrf
                @method('PUT')

                <div>
                    <label class="label">Nome</label>
                    <input name="nome"
                           value="{{ $editora->nome }}"
                           class="input input-bordered w-full"
                           required>
                </div>

                <div>
                    <label class="label">Logótipo</label>
                    <input type="file"
                           name="logotipo"
                           class="file-input w-full">
                </div>

                <button class="btn btn-warning">
                    Atualizar
                </button>
            </form>
        </div>


@endsection
