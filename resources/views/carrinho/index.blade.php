@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">🛒 O seu Carrinho</h1>

    @if ($carrinho->items->isEmpty())
        <p class="text-gray-500">O carrinho está vazio.</p>
    @else
        <table class="table w-full">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Preço</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($carrinho->items as $item)
                    @php $total += $item->livro->preco; @endphp
                    <tr>
                        <td>{{ $item->livro->nome }}</td>
                        <td>{{ number_format($item->livro->preco, 2) }} €</td>
                        <td>
                            <form method="POST" action="{{ route('carrinho.remove', $item->livro) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-error">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right font-bold">
            Total: {{ number_format($total, 2) }} €
        </div>

        <div class="mt-6 text-right">
            <a href="{{ route('checkout.endereco') }}" class="btn btn-primary">
                Finalizar Encomenda
            </a>
        </div>
    @endif
</div>
@endsection
