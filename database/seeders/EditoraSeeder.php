<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Editora;

class EditoraSeeder extends Seeder
{
    public function run(): void
    {
        Editora::create([
            'nome' => 'Porto Editora',
            'logotipo' => 'editoras/porto_editora.png'
        ]);

        Editora::create([
            'nome' => 'Leya',
            'logotipo' => 'editoras/leya.png'
        ]);

        Editora::create([
            'nome' => 'Presença',
            'logotipo' => 'editoras/presenca.png'
        ]);
    }
}
