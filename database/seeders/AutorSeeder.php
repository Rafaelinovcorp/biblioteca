<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Autor;

class AutorSeeder extends Seeder
{
    public function run(): void
    {
        Autor::create([
            'nome' => 'Andre Silva',
            'foto' => 'autores/andre-avatar.jpg',
        ]);

        Autor::create([
            'nome' => 'pedro Costa',
            'foto' => 'autores/pedro-avatar.jpg',
        ]);

        Autor::create([
            'nome' => 'andreia Pereira',
            'foto' => 'autores/andreia-avatar.jpg',
        ]);
    }
}
