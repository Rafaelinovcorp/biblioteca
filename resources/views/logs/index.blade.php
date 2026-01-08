@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">📜 Logs do Sistema</h1>
<!-- 🔎 FILTROS DOS LOGS -->
<form method="GET" class="mb-6">

    <div class="flex flex-wrap gap-4 items-end">

        <!-- PESQUISA -->
        <div class="form-control">
            <label class="label">
                <span class="label-text">Pesquisar</span>
            </label>
            <input
                type="text"
                name="search"
                placeholder="Ação ou módulo"
                class="input input-bordered w-64"
                value="{{ request('search') }}"
            />
        </div>

        <!-- UTILIZADOR -->
        <div class="form-control">
            <label class="label">
                <span class="label-text">Utilizador</span>
            </label>
            <select name="user_id" class="select select-bordered w-56">
                <option value="">Todos</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}"
                        @selected(request('user_id') == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- MÓDULO -->
        <div class="form-control">
            <label class="label">
                <span class="label-text">Módulo</span>
            </label>
            <select name="modulo" class="select select-bordered w-56">
                <option value="">Todos</option>
                @foreach ($modulos as $modulo)
                    <option value="{{ $modulo }}"
                        @selected(request('modulo') == $modulo)>
                        {{ $modulo }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- DATA -->
        <div class="form-control">
            <label class="label">
                <span class="label-text">Data</span>
            </label>
            <input
                type="date"
                name="data"
                class="input input-bordered w-40"
                value="{{ request('data') }}"
            />
        </div>

        <!-- BOTÕES -->
        <div class="flex gap-2 mb-1">
            <button class="btn btn-primary">
                Filtrar
            </button>

            <a href="{{ route('logs.index') }}" class="btn btn-outline">
                Limpar
            </a>
        </div>

    </div>
</form>


    <!-- 📋 TABELA -->
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Utilizador</th>
                <th>Módulo</th>
                <th>Ação</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->data }}</td>
                    <td>{{ $log->hora }}</td>
                    <td>{{ $log->user?->name ?? 'Sistema' }}</td>
                    <td>{{ $log->modulo }}</td>
                    <td>{{ Str::limit($log->alteracao, 60) }}</td>
                    <td>
                        <a href="{{ route('logs.show', $log) }}"
                           class="btn btn-sm btn-outline-primary">
                            Ver
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Nenhum log encontrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $logs->links() }}

</div>
@endsection
