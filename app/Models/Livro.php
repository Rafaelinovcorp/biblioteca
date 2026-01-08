<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livro extends Model
{

    use Hasfactory;

    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'categoria_id',
        'capa',
        'preco',
        'estado',
        'pdf',
    ];
    protected $casts = [
    'preco' => 'decimal:2',
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

    public function carrinhoItems()
{
    return $this->hasMany(CarrinhoItem::class);
}


    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'autor_livro');
    }

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function categoria()
{
    return $this->belongsTo(Categoria::class);
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
