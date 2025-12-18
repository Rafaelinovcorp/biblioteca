<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Requisicao;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Inicializa tudo (evita undefined variables)
        $requisicoesAtivas = 0;
        $requisicoes30Dias = 0;
        $entreguesHoje = 0;
        $minhasRequisicoes = 0;

        if ($user->role === 'admin') {

            $requisicoesAtivas = Requisicao::where('estado', 'ativa')->count();

            $requisicoes30Dias = Requisicao::where('created_at', '>=', now()->subDays(30))
                ->count();

            $entreguesHoje = Requisicao::whereDate('updated_at', today())
                ->where('estado', 'entregue')
                ->count();
        }

        if ($user->role === 'cidadao') {

            $minhasRequisicoes = Requisicao::where('user_id', $user->id)
                ->where('estado', 'ativa')
                ->count();
        }

        return view('dashboard', compact(
            'requisicoesAtivas',
            'requisicoes30Dias',
            'entreguesHoje',
            'minhasRequisicoes'
        ));
    }
}
