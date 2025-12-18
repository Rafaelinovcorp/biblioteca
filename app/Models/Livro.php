<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'capa',
        'preco',
        'estado',
        'pdf',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relações
    |--------------------------------------------------------------------------
    */

    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro');
    }

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isDisponivel(): bool
    {
        return $this->estado === 'disponivel';
    }
}
