<?php

namespace App\Http\Controllers;

use App\Models\Requisicao;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisicaoController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        $requisicoes = Requisicao::where('user_id', $user->id)
            ->with('livro')
            ->latest()
            ->paginate(20);

        return view('requisicoes.index', compact('requisicoes'));
    }

    public function create()
    {
        $livros = Livro::where('estado', 'disponivel')->get();

        return view('requisicoes.create', compact('livros'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'livro_id' => 'required|exists:livros,id',
        ]);

        $livro = Livro::findOrFail($request->livro_id);

        if ($livro->estado !== 'disponivel') {
            return back()->withErrors([
                'livro_id' => 'Este livro não está disponível.',
            ]);
        }


        if (
            $user->requisicoes()
                ->whereIn('estado', ['pendente', 'confirmado'])
                ->count() >= 3
        ) {
            return back()->withErrors([
                'limite' => 'Já tens 3 livros requisitados em simultâneo.',
            ]);
        }

        Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $livro->id,
            'estado' => 'pendente',
            'data_inicio' => now(),
            'data_fim_previsto' => now()->addDays(5),
        ]);

        $livro->update(['estado' => 'ocupado']);

        return redirect()
            ->route('requisicoes.index')
            ->with('success', 'Requisição criada com sucesso.');
    }

    public function show(Requisicao $requisicao)
    {
        $user = Auth::user();

   
        if ($requisicao->user_id !== $user->id) {
            abort(403);
        }

        $requisicao->load(['livro', 'user']);

        return view('requisicoes.show', compact('requisicao'));
    }

    public function confirmar($id)
    {

        $requisicao = Requisicao::findOrFail($id);

        if ($requisicao->estado !== 'pendente') {
            return back();
        }

        $requisicao->update([
            'estado' => 'confirmado',
        ]);

        return back()->with('success', 'Requisição confirmada.');
    }

    public function devolver($id)
    {

        $requisicao = Requisicao::findOrFail($id);

        if ($requisicao->estado !== 'confirmado') {
            return back();
        }

        $agora = now();

        $diasDecorridos = $requisicao->data_inicio->diffInDays($agora);
        $diasAtraso = max(
            0,
            $requisicao->data_fim_previsto->diffInDays($agora, false)
        );

        $requisicao->update([
            'estado' => 'entregue',
            'data_fim_real' => $agora,
            'dias_decorridos' => $diasDecorridos,
            'dias_atraso' => $diasAtraso,
            'penalizacao' => $diasAtraso * 1,
        ]);

        $requisicao->livro->update([
            'estado' => 'disponivel',
        ]);

        return back()->with('success', 'Livro devolvido com sucesso.');
    }
}
