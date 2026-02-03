<?php
namespace App\Livewire\Chat;


use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatMensagens extends Component
{
    public int $conversationId;
    public string $texto = '';

    public function mount($conversationId)
    {
        $this->conversationId = $conversationId;
    }

    public function enviar()
    {
        if (trim($this->texto) === '') {
            return;
        }

        Message::create([
            'conversation_id' => $this->conversationId,
            'user_id' => Auth::id(),
            'content' => $this->texto,
        ]);

        $this->texto = '';
    }

    public function render()
    {
        return view('livewire.chat-mensagens', [
            'mensagens' => Message::where('conversation_id', $this->conversationId)
                ->orderBy('created_at')
                ->get()
        ]);
    }
}
