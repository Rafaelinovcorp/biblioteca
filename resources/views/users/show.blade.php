@extends('layouts.default')

@section('header')
    <h2 class="text-xl font-semibold">
        {{ $user->name }}
    </h2>
@endsection

@section('content')

        <div class="p-6 max-w-3xl">
            <div class="flex gap-6 items-start">

                <img class="w-32 h-32 rounded-full object-cover"
                     src="{{ $user->foto_perfil
                        ? asset('storage/'.$user->foto_perfil)
                        : 'https://ui-avatars.com/api/?name='.$user->name }}">

                <div class="space-y-2">
                    <p><strong>Email:</strong> {{ $user->email }}</p>

                    <p>
                        <strong>Role:</strong>
                        <span class="badge {{ $user->role === 'admin' ? 'badge-error' : 'badge-info' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>

                    <p class="pt-2">
                        <strong>Requisições:</strong>
                        {{ $user->requisicoes->count() }}
                    </p>
                </div>
            </div>
        </div>


@endsection
