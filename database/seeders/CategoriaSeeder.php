<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run()
{
    $categorias = [
        'Fantasia',
        'Romance',
        'História',
        'Tecnologia',
        'Mistério',
        'Ciência',
        'Autoajuda',
        'Infantil',
        'Biografia',
        'Geral',
    ];

    foreach ($categorias as $nome) {
        \App\Models\Categoria::firstOrCreate(['nome' => $nome]);
    }
}

}
