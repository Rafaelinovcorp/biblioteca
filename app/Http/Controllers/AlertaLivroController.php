<?php

namespace App\Http\Controllers;

use App\Models\AlertaLivro;
use App\Services\LogService;
use Illuminate\Http\Request;

class AlertaLivroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id'
        ]);

        $alerta = AlertaLivro::firstOrCreate([
            'user_id' => auth()->id(),
            'livro_id' => $request->livro_id,
        ]);

        // 🔔 Log apenas se o alerta foi criado agora
        if ($alerta->wasRecentlyCreated) {
            LogService::criar(
                'Alertas',
                'Criou alerta de disponibilidade para o livro ID ' . $request->livro_id,
                $request->livro_id
            );
        }

        return back()->with('success', 'Serás avisado quando o livro estiver disponível.');
    }
}
