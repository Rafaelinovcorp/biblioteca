@extends('layouts.default')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Utilizadores</h2>

        @can('admin')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                + Novo Utilizador
            </a>
        @endcan
    </div>
@endsection

@section('content')

        <div class="p-6">
            <div class="overflow-x-auto bg-base-100 shadow rounded">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <img class="w-12 h-12 rounded-full object-cover"
                                         src="{{ $user->foto_perfil
                                            ? asset('storage/'.$user->foto_perfil)
                                            : 'https://ui-avatars.com/api/?name='.$user->name }}">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'badge-error' : 'badge-info' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="flex gap-2">
                                    <a href="{{ route('users.show', $user) }}"
                                       class="btn btn-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('users.edit', $user) }}"
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-error"
                                                onclick="return confirm('Eliminar utilizador?')">
                                            Apagar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>


@endsection
