<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';

    protected $fillable = [
        'nome',
        'foto',
    ];

    protected $casts = [
        'nome' => 'encrypted',
        'foto' => 'encrypted',
    ];

    public function livros()
    {
        // mantém a mesma pivot 'autor_livro' usada no Livro model
        return $this->belongsToMany(Livro::class, 'autor_livro', 'autor_id', 'livro_id');
    }

    protected static function booted()
{
    static::saving(function ($autor) {
        if (isset($autor->nome)) {
           
            $plain = trim($autor->nome);

           
            $autor->nome_search = mb_strtolower($plain);
        }
    });
}
}
