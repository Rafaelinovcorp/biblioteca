<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatLayout extends Component
{
    public ?Conversation $activeConversation = null;

    protected $listeners = [
        'conversationSelected' => 'setConversation',
    ];

    /**
     * Executa ao carregar a página
     * Permite abrir conversa automaticamente via query string
     * ex: /chat?conversation=5
     */
    public function mount(): void
    {
        $conversationId = request('conversation');

        if ($conversationId) {
            $this->setConversation((int) $conversationId);
        }
    }

    /**
     * Recebe o ID da conversa (DM ou sala)
     */
    public function setConversation(int $conversationId): void
    {
        $conversation = Conversation::findOrFail($conversationId);

   
        if (! $conversation->users->contains(Auth::id())) {
            abort(403);
        }

        $this->activeConversation = $conversation;
    }

    public function render()
    {
        return view('livewire.chat.chat-layout');
    }
}
