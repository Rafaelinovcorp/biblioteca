<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autor extends Model
{

    protected $table = 'autores';

    protected $fillable = [
        'nome',
        'foto',
        'bibliografia',
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}
