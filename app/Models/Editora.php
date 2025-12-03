<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Editora extends Model
{
    use HasFactory;

    protected $table = 'editoras';

    protected $fillable = [
        'nome',
        'logotipo',
    ];

    protected $casts = [
        'nome'     => 'encrypted',
        'logotipo' => 'encrypted',
    ];

    public function livros()
    {
        return $this->hasMany(Livro::class);
    }

    protected static function booted()
{
    static::saving(function ($editora) {
        if (isset($editora->nome)) {
            $plain = trim($editora->nome);
            $normalized = Str::ascii($plain);
            $editora->nome_search = mb_strtolower($normalized);
        }
    });
}
}
