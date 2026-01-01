<?php

namespace App\Mail;

use App\Models\Carrinho;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CarrinhoInativoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Carrinho $carrinho;

    /**
     * Create a new message instance.
     */
    public function __construct(Carrinho $carrinho)
    {
        $this->carrinho = $carrinho;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Precisa de ajuda com a sua encomenda?')
            ->markdown('emails.carrinho.inativo', [
                'carrinho' => $this->carrinho,
            ]);
    }
}
