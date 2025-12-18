@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">📊 Dashboard</h1>

{{-- ADMIN --}}
@if(auth()->user()->role === 'admin')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-base-100 shadow p-4">
        <div class="text-sm text-gray-500">Requisições Ativas</div>
        <div class="text-3xl font-bold">{{ $requisicoesAtivas }}</div>
    </div>

    <div class="card bg-base-100 shadow p-4">
        <div class="text-sm text-gray-500">Últimos 30 dias</div>
        <div class="text-3xl font-bold">{{ $requisicoes30Dias }}</div>
    </div>

    <div class="card bg-base-100 shadow p-4">
        <div class="text-sm text-gray-500">Entregues Hoje</div>
        <div class="text-3xl font-bold">{{ $entreguesHoje }}</div>
    </div>
</div>

@endif

{{-- CIDADÃO --}}
@if(auth()->user()->role === 'cidadao')

<div class="card bg-base-100 shadow p-6">
    <div class="text-sm text-gray-500">As tuas requisições ativas</div>
    <div class="text-3xl font-bold mb-4">{{ $minhasRequisicoes }}</div>

    <a href="{{ route('requisicoes.index') }}" class="btn btn-primary btn-sm">
        Ver Requisições
    </a>
</div>

@endif

@endsection
