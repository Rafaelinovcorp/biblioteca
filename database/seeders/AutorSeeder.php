<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Autor;

class AutorSeeder extends Seeder
{
    public function run(): void
    {
        Autor::create([
            'nome' => 'José Saramago',
            'foto' => 'autores/saramago.jpg',
            'bibliografia' => 'Autor português, Prémio Nobel da Literatura.'
        ]);

        Autor::create([
            'nome' => 'Eça de Queirós',
            'foto' => 'autores/eca.jpg',
            'bibliografia' => 'Um dos maiores escritores do realismo português.'
        ]);

        Autor::create([
            'nome' => 'Fernando Pessoa',
            'foto' => 'autores/pessoa.jpg',
            'bibliografia' => 'Poeta português conhecido pelos seus heterónimos.'
        ]);
    }
}
