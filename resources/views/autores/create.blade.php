@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">
        Novo Autor
    </h2>
@endsection

@section('content')
    <div class="p-6 max-w-xl">

        <form method="POST"
              enctype="multipart/form-data"
              action="{{ route('autores.store') }}"
              class="space-y-4">

            @csrf

            <div>
                <label class="label">Nome</label>
                <input name="nome"
                       class="input input-bordered w-full"
                       required>
            </div>

            <div>
                <label class="label">Bibliografia</label>
                <textarea name="bibliografia"
                          class="textarea textarea-bordered w-full"></textarea>
            </div>

            <div>
                <label class="label">Foto</label>
                <input type="file"
                       name="foto"
                       class="file-input w-full">
            </div>

            <button class="btn btn-primary">
                Guardar
            </button>

        </form>
    </div>
@endsection
