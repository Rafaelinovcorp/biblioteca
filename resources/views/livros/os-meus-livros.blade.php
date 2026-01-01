@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-8">📚 Os meus livros</h1>

    {{-- ================= REQUISIÇÕES ================= --}}
    <h2 class="text-xl font-semibold mb-4">📘 Livros requisitados</h2>

    @if($requisicoes->isEmpty())
        <p class="text-gray-500 mb-6">Não tens livros requisitados de momento.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-10">
            @foreach($requisicoes as $req)
                <div class="p-4 border rounded-lg bg-base-200">
                    <h3 class="font-semibold">{{ $req->livro->nome }}</h3>
                    <p class="text-sm text-gray-500">
                        Estado: {{ ucfirst($req->estado) }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ================= COMPRAS ================= --}}
    <h2 class="text-xl font-semibold mb-4">🛒 Livros comprados</h2>

    @if($compras->isEmpty())
        <p class="text-gray-500">Ainda não compraste nenhum livro.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($compras as $item)
                <div class="p-4 border rounded-lg bg-base-200">
                    <h3 class="font-semibold">{{ $item->livro->nome }}</h3>
                    <p class="text-sm text-gray-500">
                        Preço: €{{ number_format($item->preco, 2) }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
