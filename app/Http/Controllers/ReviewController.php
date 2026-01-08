<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Requisicao;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CIDADÃO — Criar review
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Requisicao $requisicao)
    {
        $user = Auth::user();

        // 1️⃣ Só o dono da requisição
        if ($requisicao->user_id !== $user->id) {
            abort(403);
        }

        // 2️⃣ Requisição tem de estar entregue
        if ($requisicao->estado !== 'entregue') {
            return back()->withErrors('Só podes avaliar após devolver o livro.');
        }

        // 3️⃣ Nunca se foi cancelada
        if ($requisicao->estado === 'cancelado') {
            return back()->withErrors('Esta requisição não pode ser avaliada.');
        }

        // 4️⃣ Só uma review por requisição
        if ($requisicao->review) {
            return back()->withErrors('Já existe uma review para esta requisição.');
        }

        // 5️⃣ Validação do conteúdo
        $request->validate([
            'comentario' => 'required|string|min:5',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $review = Review::create([
            'requisicao_id' => $requisicao->id,
            'user_id'       => $user->id,
            'livro_id'      => $requisicao->livro_id,
            'comentario'    => $request->comentario,
            'rating'        => $request->rating,
            'estado'        => 'pendente',
        ]);

        LogService::criar(
            'Reviews',
            'Criou review para o livro ID ' . $requisicao->livro_id,
            $review->id
        );

        return back()->with(
            'success',
            'Review enviada com sucesso. Aguarda aprovação do administrador.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Listar reviews pendentes
    |--------------------------------------------------------------------------
    */
    public function pendentes()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $reviews = Review::where('estado', 'pendente')
            ->with(['user', 'livro', 'requisicao'])
            ->latest()
            ->get();

        return view('reviews.pendentes', compact('reviews'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Aprovar review
    |--------------------------------------------------------------------------
    */
    public function aprovar(Review $review)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($review->estado !== 'pendente') {
            return back()->withErrors('Esta review já foi tratada.');
        }

        $review->update([
            'estado' => 'ativa',
        ]);

        LogService::criar(
            'Reviews',
            'Aprovou review',
            $review->id
        );

        return back()->with('success', 'Review aprovada.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN — Recusar review
    |--------------------------------------------------------------------------
    */
    public function recusar(Request $request, Review $review)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($review->estado !== 'pendente') {
            return back()->withErrors('Esta review já foi tratada.');
        }

        $request->validate([
            'justificacao' => 'required|string|min:5',
        ]);

        $review->update([
            'estado' => 'recusada',
            'justificacao' => $request->justificacao,
        ]);

        LogService::criar(
            'Reviews',
            'Recusou review',
            $review->id
        );

        return back()->with('success', 'Review recusada.');
    }
}
