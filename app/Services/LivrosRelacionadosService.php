<?php

namespace App\Services;

use App\Models\Livro;

class LivrosRelacionadosService
{
    public static function get(Livro $livro, int $limite = 5)
    {
        if (!$livro->categoria_id) {
            return collect();
        }

        return Livro::where('categoria_id', $livro->categoria_id)
            ->where('id', '!=', $livro->id)
            ->where('estado', 'disponivel')
            ->limit($limite)
            ->get();
    }
}
