<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Requisicao;
use App\Models\EncomendaItem;

class OsMeusLivrosController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 📘 Livros requisitados (ativos)
        $requisicoes = Requisicao::with('livro')
            ->where('user_id', $user->id)
            ->whereIn('estado', ['pendente', 'confirmada'])
            ->get();

        // 🛒 Livros comprados (encomendas pagas)
        $compras = EncomendaItem::with('livro')
            ->whereHas('encomenda', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('estado', 'paga');
            })
            ->get();

        return view('livros.os-meus-livros', compact('requisicoes', 'compras'));
    }
}
