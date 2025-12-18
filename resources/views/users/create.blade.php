@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">Novo Utilizador</h2>
@endsection

@section('content')


        <div class="p-6 max-w-xl">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('users.store') }}"
                  class="space-y-4">

                @csrf

                <input name="name"
                       class="input input-bordered w-full"
                       placeholder="Nome"
                       required>

                <input name="email"
                       type="email"
                       class="input input-bordered w-full"
                       placeholder="Email"
                       required>

                <input name="password"
                       type="password"
                       class="input input-bordered w-full"
                       placeholder="Password"
                       required>

                <input name="password_confirmation"
                       type="password"
                       class="input input-bordered w-full"
                       placeholder="Confirmar Password"
                       required>

                <select name="role"
                        class="select select-bordered w-full">
                    <option value="cidadao">Cidadão</option>
                    <option value="admin">Admin</option>
                </select>

                <input type="file"
                       name="foto_perfil"
                       class="file-input w-full"
                       required>

                <button class="btn btn-primary">
                    Criar
                </button>
            </form>
        </div>


@endsection
