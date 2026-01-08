<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Models\Encomenda;
use App\Models\Carrinho;
use App\Services\LogService;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $secret
            );
        } catch (\Exception $e) {
            return response('Webhook inválido', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;

            $encomendaId = $paymentIntent->metadata->encomenda_id ?? null;

            if (!$encomendaId) {
                return response('Sem encomenda_id', 200);
            }

            $encomenda = Encomenda::find($encomendaId);

            if ($encomenda && $encomenda->estado !== 'paga') {
                $encomenda->update([
                    'estado' => 'paga',
                ]);

                Carrinho::where('user_id', $encomenda->user_id)->delete();

                LogService::criar(
                    'Stripe',
                    'Pagamento confirmado via webhook (encomenda paga)',
                    $encomenda->id
                );
            }
        }

        return response('OK', 200);
    }
}
