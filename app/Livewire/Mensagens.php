<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Mensagem;

class Mensagens extends Component
{
    public function render()
    {
        return view('livewire.mensagens', [
            'mensagens' => Mensagem::latest()->take(20)->get()
        ]);
    }
}
