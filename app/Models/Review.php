<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'requisicao_id',
        'user_id',
        'livro_id',
        'rating',
        'comentario',
        'estado',
        'justificacao',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relações
    |--------------------------------------------------------------------------
    */

    public function requisicao()
    {
        return $this->belongsTo(Requisicao::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
