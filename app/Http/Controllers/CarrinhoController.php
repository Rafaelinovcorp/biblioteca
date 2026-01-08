<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\Livro;
use App\Services\LogService;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function index()
    {
        $carrinho = Carrinho::with('items.livro')
            ->firstOrCreate(['user_id' => auth()->id()]);

        return view('carrinho.index', compact('carrinho'));
    }

    public function add(Livro $livro)
    {
        $carrinho = Carrinho::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $item = $carrinho->items()->firstOrCreate([
            'livro_id' => $livro->id
        ]);

        // 🔔 Log apenas se o livro foi realmente adicionado agora
        if ($item->wasRecentlyCreated) {
            LogService::criar(
                'Carrinho',
                'Adicionou o livro ao carrinho: ' . $livro->nome,
                $livro->id
            );
        }

        return back()->with('success', 'Livro adicionado ao carrinho');
    }

    public function remove(Livro $livro)
    {
        $carrinho = Carrinho::where('user_id', auth()->id())->first();

        if ($carrinho) {
            $apagado = $carrinho->items()
                ->where('livro_id', $livro->id)
                ->exists();

            $carrinho->items()->where('livro_id', $livro->id)->delete();

            if ($apagado) {
                LogService::criar(
                    'Carrinho',
                    'Removeu o livro do carrinho: ' . $livro->nome,
                    $livro->id
                );
            }
        }

        return back();
    }
}
