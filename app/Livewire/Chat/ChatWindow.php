<?php
namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;

class ChatWindow extends Component
{
    public Conversation $conversation;
    public string $message = '';

    public function send()
    {
        Message::create([
            'conversation_id' => $this->conversation->id,
            'user_id' => auth()->id(),
            'content' => $this->message,
        ]);

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat.chat-window', [
            'messages' => $this->conversation
                ->messages()
                ->with('user')
                ->latest()
                ->get()
                ->reverse(),
        ]);
    }
}
