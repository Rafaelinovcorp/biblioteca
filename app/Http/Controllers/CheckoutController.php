<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Models\Carrinho;
use App\Models\Endereco;
use App\Models\Encomenda;
use App\Models\EncomendaItem;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $carrinho = Carrinho::with('items.livro')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $total = $carrinho->items->sum(fn ($i) => $i->livro->preco);

        $endereco = Endereco::create([
            'user_id' => auth()->id(),
            'nome' => $request->nome,
            'rua' => $request->rua,
            'codigo_postal' => $request->codigo_postal,
            'cidade' => $request->cidade,
            'pais' => $request->pais,
        ]);

        $encomenda = Encomenda::create([
            'user_id' => auth()->id(),
            'endereco_id' => $endereco->id,
            'total' => $total,
        ]);

        foreach ($carrinho->items as $item) {
            EncomendaItem::create([
                'encomenda_id' => $encomenda->id,
                'livro_id' => $item->livro->id,
                'preco' => $item->livro->preco,
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'metadata' => [
                'encomenda_id' => $encomenda->id
            ]
        ]);

        $encomenda->update([
            'stripe_payment_intent_id' => $intent->id
        ]);

        return view('checkout.pay', [
            'clientSecret' => $intent->client_secret
        ]);
    }
}
