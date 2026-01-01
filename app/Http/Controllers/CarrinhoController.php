<?php
namespace App\Http\Controllers;

use App\Models\Carrinho;
use App\Models\Livro;
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

        $carrinho->items()->firstOrCreate([
            'livro_id' => $livro->id
        ]);

        return back()->with('success', 'Livro adicionado ao carrinho');
    }

    public function remove(Livro $livro)
    {
        $carrinho = Carrinho::where('user_id', auth()->id())->first();

        if ($carrinho) {
            $carrinho->items()->where('livro_id', $livro->id)->delete();
        }

        return back();
    }
}
