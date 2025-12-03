<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Livro::with(['autores', 'editora']);

        if ($request->filled('nome')) {
            $nome = trim($request->input('nome'));
            $nomeNormalized = Str::ascii(mb_strtolower($nome));
            $query->where('nome_search', 'like', $nomeNormalized . '%');
        }

        if ($request->filled('autor_id')) {
            $autorId = $request->input('autor_id');
            $query->whereHas('autores', function ($q) use ($autorId) {
                $q->where('autores.id', $autorId);
            });
        }

        if ($request->filled('editora_id')) {
            $query->where('editora_id', $request->input('editora_id'));
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->input('preco_min'));
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->input('preco_max'));
        }

        $precoOrder = $request->query('preco_order');
        if (in_array($precoOrder, ['asc', 'desc'])) {
            $query->orderBy('preco', $precoOrder);
        } else {
            $query->orderBy('nome');
        }

        $livros = $query->paginate(10)->withQueryString();
        $autores = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();

        return view('dashboard', compact('livros', 'autores', 'editoras', 'precoOrder'));
    }
}
