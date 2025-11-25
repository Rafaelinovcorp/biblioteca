<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autor extends Model
{
    protected $fillable = ['nome', 'foto'];

     protected $casts = [
        'nome' => 'encrypted:string',
        'foto' => 'encrypted:string',
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'autor_livro');
    }
}
