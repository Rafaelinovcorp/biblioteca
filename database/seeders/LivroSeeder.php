<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivroSeeder extends Seeder
{
    public function run(): void
    {
       
        $livro1 = Livro::create([
            'nome'       => 'Laravel para Iniciantes',
            'isbn'       => '978000000001',
            'ano'        => 2023,
            'preco'      => 24.99,
            'editora_id' => 1,
            'pdf_path'   => 'livros/laravel.pdf',
        ]);
        $livro1->autores()->attach([1]);  

       
        $livro2 = Livro::create([
            'nome'       => 'PHP Moderno',
            'isbn'       => '978000000002',
            'ano'        => 2022,
            'preco'      => 29.90,
            'editora_id' => 2,
            'pdf_path'   => 'livros/php.pdf',

        ]);
        $livro2->autores()->attach([2]);   

        
        $livro3 = Livro::create([
            'nome'       => 'Padrões de Projeto',
            'isbn'       => '978000000003',
            'ano'        => 2021,
            'preco'      => 34.50,
            'editora_id' => 3,
            'pdf_path'   => 'livros/padroes.pdf',
        ]);
        $livro3->autores()->attach([3]);   
    }
}
