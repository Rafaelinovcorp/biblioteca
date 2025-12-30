<?php

namespace App\Mail;

use App\Models\Livro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LivroDisponivelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $livro;

    public function __construct(Livro $livro)
    {
        $this->livro = $livro;
    }

    public function build()
    {
        $subject = '📚 Livro disponível — ' . ($this->livro->titulo ?? $this->livro->nome);

        $mail = $this->subject($subject)
            ->markdown('emails.livros.disponivel')
            ->with([
                'livro' => $this->livro,
            ]);

        // Anexa a capa se existir (igual ao teu padrão)
        if (!empty($this->livro->capa) && Storage::disk('public')->exists($this->livro->capa)) {
            $mail->attach(
                storage_path('app/public/' . $this->livro->capa),
                ['as' => 'capa_livro_' . $this->livro->id . '.jpg']
            );
        }

        return $mail;
    }
}
