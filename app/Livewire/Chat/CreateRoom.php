<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class CreateRoom extends Component
{
    public string $name = '';
    public array $users = [];

    public function create()
    {

        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $this->validate([
            'name' => 'required|min:3',
            'users' => 'required|array|min:1',
        ]);

        $room = Conversation::createRoom(
            $this->name,
            $this->users,
            Auth::id()
        );

    
        return redirect()->route('chat.index', [
            'conversation' => $room->id,
        ]);
    }

  public function render()
{
    return view('livewire.chat.create-room', [
        'allUsers' => User::where('id', '!=', Auth::id())->get(),
    ]);
}

}
