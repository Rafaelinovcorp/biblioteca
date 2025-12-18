@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">Editar Utilizador</h2>
@endsection

@section('content')


        <div class="p-6 max-w-xl">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('users.update', $user) }}"
                  class="space-y-4">

                @csrf
                @method('PUT')

                <input name="name"
                       value="{{ $user->name }}"
                       class="input input-bordered w-full"
                       required>

                <input name="email"
                       type="email"
                       value="{{ $user->email }}"
                       class="input input-bordered w-full"
                       required>

                <select name="role"
                        class="select select-bordered w-full">
                    <option value="cidadao" @selected($user->role === 'cidadao')>
                        Cidadão
                    </option>
                    <option value="admin" @selected($user->role === 'admin')>
                        Admin
                    </option>
                </select>

                <input type="file"
                       name="foto_perfil"
                       class="file-input w-full">

                <input name="password"
                       type="password"
                       class="input input-bordered w-full"
                       placeholder="Nova password (opcional)">

                <input name="password_confirmation"
                       type="password"
                       class="input input-bordered w-full"
                       placeholder="Confirmar nova password">

                <button class="btn btn-warning">
                    Atualizar
                </button>
            </form>
        </div>
 

@endsection
