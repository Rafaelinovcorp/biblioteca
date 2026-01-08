@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">🧾 Detalhes do Log</h1>

    <div class="card">
        <div class="card-body">

            <dl class="row">
                <dt class="col-sm-3">Data</dt>
                <dd class="col-sm-9">{{ $log->data }} {{ $log->hora }}</dd>

                <dt class="col-sm-3">Utilizador</dt>
                <dd class="col-sm-9">
                    {{ $log->user?->name ?? 'Sistema' }}
                </dd>

                <dt class="col-sm-3">Módulo</dt>
                <dd class="col-sm-9">{{ $log->modulo }}</dd>

                <dt class="col-sm-3">ID do Objeto</dt>
                <dd class="col-sm-9">
                    {{ $log->objeto_id ?? '-' }}
                </dd>

                <dt class="col-sm-3">Ação</dt>
                <dd class="col-sm-9">
                    {{ $log->alteracao }}
                </dd>

                <dt class="col-sm-3">IP</dt>
                <dd class="col-sm-9">{{ $log->ip }}</dd>

                <dt class="col-sm-3">Browser</dt>
                <dd class="col-sm-9">{{ $log->browser }}</dd>

                <dt class="col-sm-3">Criado em</dt>
                <dd class="col-sm-9">{{ $log->created_at }}</dd>
            </dl>

        </div>
    </div>

    <a href="{{ route('logs.index') }}" class="btn btn-secondary mt-3">
        Voltar
    </a>

</div>
@endsection
