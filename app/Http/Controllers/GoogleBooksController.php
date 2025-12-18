<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleBooksService;

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

        // guardar resultados na sessão (volumeId => item)
        $mapped = collect($items)->mapWithKeys(function ($item) {
            return [$item['id'] => $item];
        })->toArray();

        session(['google_books_results' => $mapped]);

        return view('google-books.index', [
            'results' => $mapped,
            'query' => $request->q,
        ]);
    }

    public function import(string $volumeId, GoogleBooksService $service)
    {
     

        $results = session('google_books_results', []);

        if (!isset($results[$volumeId])) {
            return redirect()
                ->route('google-books.index')
                ->withErrors('Resultado expirou. Pesquisa novamente.');
        }

        $livro = $service->importVolumeToDatabase($results[$volumeId]);

        return redirect()
            ->route('livros.show', $livro)
            ->with('success', 'Livro importado com sucesso da Google Books.');
    }
}
