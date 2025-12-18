<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Requisicao;

class RequisicaoConfirmadaMail extends Mailable {
    use Queueable, SerializesModels;

    public $requisicao;

    public function __construct(Requisicao $requisicao) {
        $this->requisicao = $requisicao;
    }

    public function build()
{
    return $this->subject('Requisição #' . $this->requisicao->numero)
        ->view('emails.requisicao_confirmada');
}

}
