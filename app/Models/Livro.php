<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livro extends Model
{
      protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'imagem_capa',
        'preco',
    ];

     protected $casts = [
        'isbn'         => 'encrypted:string',
        'nome'         => 'encrypted:string',
        'bibliografia' => 'encrypted:string',
        'imagem_capa'  => 'encrypted:string',
        'preco'        => 'decimal:2',
    ];

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro');
    }
}
