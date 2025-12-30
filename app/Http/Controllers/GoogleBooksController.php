<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleBooksService;
use App\Models\Categoria;

class GoogleBooksController extends Controller
{
    public function index()
    {
        return view('google-books.index');
    }

    public function search(Request $request, GoogleBooksService $service)
    {
        $request->validate([
            'q' => 'required|string|min:3',
        ]);

        $response = $service->search($request->q, 10);
        $items = $response['items'] ?? [];

        // guardar resultados na sessão
        $mapped = collect($items)->mapWithKeys(fn ($item) => [
            $item['id'] => $item
        ])->toArray();

        session(['google_books_results' => $mapped]);

        return view('google-books.index', [
            'results' => $mapped,
            'query'   => $request->q,
        ]);
    }

    /**
     * ECRÃ INTERMÉDIO DE CONFIRMAÇÃO
     */
   public function confirm(string $volumeId, GoogleBooksService $service)
{
    $volume = $service->getById($volumeId);

    if (empty($volume) || isset($volume['error'])) {
        return redirect()
            ->route('google-books.index')
            ->withErrors('Não foi possível obter os dados do livro.');
    }

    $categorias = \App\Models\Categoria::orderBy('nome')->get();

    return view('google-books.confirm', compact('volume', 'categorias', 'volumeId'));
}


    /**
     * IMPORT FINAL
     */
public function store(string $volumeId, Request $request, GoogleBooksService $service)
{
    // validação manual (evita lock de sessão)
    if (
        !$request->filled('categoria_id') ||
        !\App\Models\Categoria::where('id', $request->categoria_id)->exists()
    ) {
        return back()->withErrors('Categoria inválida.');
    }

    $volume = $service->getById($volumeId);

    if (empty($volume) || isset($volume['error'])) {
        return redirect()
            ->route('google-books.index')
            ->withErrors('Não foi possível obter os dados do livro.');
    }

    $livro = $service->importVolumeToDatabase($volume, (int) $request->categoria_id);

    return redirect()
        ->route('livros.show', $livro)
        ->with('success', 'Livro importado com sucesso.');
}


}
