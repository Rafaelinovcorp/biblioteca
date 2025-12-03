<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'isbn',
        'ano',
        'preco',
        'editora_id',
        'pdf_path',
        'nome_search', // campo de pesquisa (não encriptado)
    ];

    /**
     * Campos com cast de encriptação.
     * Atenção: campos encriptados não podem ser pesquisados/ordenados na BD.
     */
    protected $casts = [
        'nome'     => 'encrypted',
        'isbn'     => 'encrypted',
        'ano'      => 'encrypted',
        'preco'    => 'encrypted',
        'pdf_path' => 'encrypted',
    ];

    /**
     * Mantém o campo nome_search actualizado automaticamente.
     */
    protected static function booted()
    {
        static::saving(function ($livro) {
            if (isset($livro->nome)) {
                $plain = trim($livro->nome);
                $normalized = Str::ascii($plain);
                $livro->nome_search = mb_strtolower($normalized);
            }
        });
    }

    public function autores()
    {
        // especifica a tabela pivot e as chaves para evitar ambiguidades
        return $this->belongsToMany(Autor::class, 'autor_livro', 'livro_id', 'autor_id');
    }

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }
}
