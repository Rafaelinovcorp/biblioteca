public function via($notifiable)
{
    return ['database'];
}

public function toArray($notifiable)
{
    return [
        'mensagem' => 'Nova requisição #' . $this->requisicao->numero,
        'url' => route('requisicoes.show', $this->requisicao),
    ];
}
