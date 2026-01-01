@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">📦 Morada de Entrega</h1>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf

        <input class="input input-bordered w-full mb-2" name="nome" placeholder="Nome completo" required>
        <input class="input input-bordered w-full mb-2" name="rua" placeholder="Rua" required>
        <input class="input input-bordered w-full mb-2" name="codigo_postal" placeholder="Código Postal" required>
        <input class="input input-bordered w-full mb-2" name="cidade" placeholder="Cidade" required>
        <input class="input input-bordered w-full mb-4" name="pais" placeholder="País" required>

        <button class="btn btn-primary w-full">
            Continuar para Pagamento
        </button>
    </form>
</div>
@endsection
