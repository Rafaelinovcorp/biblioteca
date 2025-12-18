@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">Nova Editora</h2>
@endsection

@section('content')


        <div class="p-6 max-w-xl">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('editoras.store') }}"
                  class="space-y-4">

                @csrf

                <div>
                    <label class="label">Nome</label>
                    <input name="nome"
                           class="input input-bordered w-full"
                           required>
                </div>

                <div>
                    <label class="label">Logótipo</label>
                    <input type="file"
                           name="logotipo"
                           class="file-input w-full">
                </div>

                <button class="btn btn-primary">
                    Guardar
                </button>
            </form>
        </div>


@endsection
