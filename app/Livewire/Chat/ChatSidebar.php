<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatSidebar extends Component
{
    public function render()
    {
        return view('livewire.chat.chat-sidebar', [
            // utilizadores para DM
            'users' => User::where('id', '!=', Auth::id())->get(),

            // salas onde o user participa
            'rooms' => Conversation::where('type', 'room')
                ->whereHas('users', fn ($q) => $q->where('users.id', Auth::id()))
                ->get(),

            'isAdmin' => Auth::user()->role === 'admin',
        ]);
    }

    /**
     * Abrir / criar conversa direta
     */
    public function openDirect(int $userId): void
    {
        $userA = Auth::user();
        $userB = User::findOrFail($userId);

        $conversation = Conversation::getOrCreateDirect($userA, $userB);

        $this->dispatch('conversationSelected', $conversation->id);
    }

    /**
     * Abrir sala existente
     */
    public function openRoom(int $roomId): void
    {
        $this->dispatch('conversationSelected', $roomId);
    }
}
