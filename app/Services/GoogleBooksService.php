<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\Autor;

class GoogleBooksService
{
    protected string $base = 'https://www.googleapis.com/books/v1/volumes';
    private const PRECO_DEFAULT = 9.99;

    public function search(string $q, int $max = 10): array
    {
        return Http::timeout(5)
            ->get($this->base, [
                'q' => $q,
                'maxResults' => $max,
            ])
            ->json();
    }

public function importVolumeToDatabase(array $volume, int $categoriaId): Livro
{
    $info = $volume['volumeInfo'] ?? [];

   
    $isbn = collect($info['industryIdentifiers'] ?? [])
        ->first(fn ($i) => in_array($i['type'] ?? '', ['ISBN_13', 'ISBN_10']))['identifier']
        ?? Str::uuid()->toString();

    $editora = Editora::firstOrCreate([
        'nome' => $info['publisher'] ?? 'Google Books',
    ]);

    $preco = $volume['saleInfo']['listPrice']['amount']
        ?? self::PRECO_DEFAULT;


    $livro = Livro::create([
        'isbn'          => $isbn,
        'nome'          => $info['title'] ?? 'Sem título',
        'bibliografia'  => $info['description'] ?? null,
        'editora_id'    => $editora->id,
        'categoria_id'  => $categoriaId,
        'preco'         => round($preco, 2),
        'estado'        => 'disponivel',
        'capa'          => null,
    ]);

 
    foreach ($info['authors'] ?? [] as $authorName) {
        $autor = Autor::firstOrCreate(['nome' => $authorName]);
        $livro->autores()->syncWithoutDetaching($autor->id);
    }

 
    if (!empty($info['imageLinks']['thumbnail'])) {
        try {
            $img = Http::timeout(2) 
                ->get(str_replace('http://', 'https://', $info['imageLinks']['thumbnail']));

            if ($img->successful()) {
                $path = 'capas/' . Str::uuid() . '.jpg';
                Storage::disk('public')->put($path, $img->body());

              
                $livro->update(['capa' => $path]);
            }
        } catch (\Throwable $e) {
     
        }
    }

    return $livro;
}

public function getById(string $volumeId): array
{
    return Http::timeout(5)
        ->get($this->base . '/' . $volumeId)
        ->json();
}


}
