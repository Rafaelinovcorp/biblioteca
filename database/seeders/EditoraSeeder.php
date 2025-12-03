<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Editora;

class EditoraSeeder extends Seeder
{
    public function run(): void
    {
        Editora::create([
            'nome'     => 'Editora Alfa',
            'logotipo' => 'editoras/1-1fa0cfae.jpg',
        ]);

        Editora::create([
            'nome'     => 'Editora Beta',
            'logotipo' => 'editoras/2-1fa0cfae.jpg',
        ]);

        Editora::create([
            'nome'     => 'Editora Gama',
            'logotipo' => 'editoras/3-1fa0cfae.jpg',
        ]);
    }
}
