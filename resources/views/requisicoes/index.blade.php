@extends('layouts.default')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl">Requisições</h2>

        @auth
            <a href="{{ route('requisicoes.create') }}" class="btn btn-primary btn-sm">
                + Nova Requisição
            </a>
        @endauth
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="overflow-x-auto bg-base-100 rounded shadow">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Livro</th>
                        @can('admin')
                            <th>Cidadão</th>
                        @endcan
                        <th>Início</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requisicoes as $r)
                        <tr>
                            <td>{{ $r->numero }}</td>
                            <td>{{ $r->livro->nome }}</td>

                            @can('admin')
                                <td>{{ $r->user->name }}</td>
                            @endcan

                            <td>{{ $r->data_inicio->format('d/m/Y') }}</td>

                            <td>
                                <span class="badge
                                    @if($r->estado === 'pendente') badge-warning
                                    @elseif($r->estado === 'confirmado') badge-info
                                    @elseif($r->estado === 'entregue') badge-success
                                    @endif">
                                    {{ ucfirst($r->estado) }}
                                </span>
                            </td>

                            <td class="flex gap-2">

                                <a href="{{ route('requisicoes.show', $r) }}"
                                   class="btn btn-outline btn-sm">
                                    Ver
                                </a>

                                @can('admin')

                                    @if($r->estado === 'pendente')
                                        <form method="POST"
                                              action="{{ route('requisicoes.confirmar', $r) }}">
                                            @csrf
                                            <button class="btn btn-info btn-sm">
                                                Confirmar
                                            </button>
                                        </form>
                                    @endif

                                    @if($r->estado === 'confirmado')
                                        <form method="POST"
                                              action="{{ route('requisicoes.devolver', $r) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm">
                                                Entregar
                                            </button>
                                        </form>
                                    @endif

                                @endcan
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500">
                                Nenhuma requisição encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $requisicoes->links() }}
        </div>
    </div>
@endsection
