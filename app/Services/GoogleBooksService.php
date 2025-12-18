<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\Autor;

class GoogleBooksService
{
    protected string $base = 'https://www.googleapis.com/books/v1/volumes';

    public function search(string $q, int $max = 10): ?array
    {
        $res = Http::get($this->base, [
            'q' => $q,
            'maxResults' => $max,
        ]);

        return $res->successful() ? $res->json() : null;
    }

    /**
     * Importa um volume da Google Books para a base de dados.
     * Garante SEMPRE a existência de uma editora válida.
     */
    public function importVolumeToDatabase(array $volume): Livro
    {
        $info = $volume['volumeInfo'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | ISBN
        |--------------------------------------------------------------------------
        */
        $isbn = null;

        if (!empty($info['industryIdentifiers'])) {
            foreach ($info['industryIdentifiers'] as $id) {
                if (in_array($id['type'] ?? '', ['ISBN_13', 'ISBN_10'])) {
                    $isbn = $id['identifier'];
                    break;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EDITORA (NUNCA NULL)
        |--------------------------------------------------------------------------
        | - Se a API trouxer publisher → usar/criar
        | - Se NÃO trouxer → usar/criar "Google Books"
        */
        $publisher = $info['publisher'] ?? 'Google Books';

        $editora = Editora::firstOrCreate([
            'nome' => $publisher,
        ]);

        /*
        |--------------------------------------------------------------------------
        | LIVRO
        |--------------------------------------------------------------------------
        */
        $livro = Livro::updateOrCreate(
            ['isbn' => $isbn],
            [
                'nome' => $info['title'] ?? 'Sem título',
                'editora_id' => $editora->id, // 🔒 nunca null
                'bibliografia' => $info['description'] ?? null,
                'capa' => $info['imageLinks']['thumbnail'] ?? null,
                'preco' => null,
                'estado' => 'disponivel',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | AUTORES
        |--------------------------------------------------------------------------
        */
        if (!empty($info['authors'])) {
            foreach ($info['authors'] as $authorName) {
                $autor = Autor::firstOrCreate([
                    'nome' => $authorName,
                ]);

                $livro->autores()->syncWithoutDetaching($autor->id);
            }
        }

        return $livro;
    }
}
