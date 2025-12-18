<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;

class LivroSeeder extends Seeder
{
    public function run(): void
    {
        $autor1 = Autor::first();
        $autor2 = Autor::skip(1)->first();
        $autor3 = Autor::skip(2)->first();

        $editora1 = Editora::first();
        $editora2 = Editora::skip(1)->first();
        $editora3 = Editora::skip(2)->first();

        $livro1 = Livro::create([
            'isbn' => '9789724621081',
            'nome' => 'Ensaio sobre a Cegueira',
            'editora_id' => $editora1->id,
            'bibliografia' => 'Romance distópico sobre uma epidemia de cegueira.',
            'capa' => 'capas/cegueira.jpg',
            'preco' => 19.90,
            'estado' => 'disponivel',
            'pdf' => 'pdfs/cegueira.pdf'
        ]);

        $livro1->autores()->attach($autor1->id);

        $livro2 = Livro::create([
            'isbn' => '9789722638142',
            'nome' => 'Os Maias',
            'editora_id' => $editora2->id,
            'bibliografia' => 'Crítica à sociedade portuguesa do século XIX.',
            'capa' => 'capas/maias.jpg',
            'preco' => 17.50,
            'estado' => 'disponivel',
            'pdf' => 'pdfs/maias.pdf'
        ]);

        $livro2->autores()->attach($autor2->id);

        $livro3 = Livro::create([
            'isbn' => '9789720420008',
            'nome' => 'Mensagem',
            'editora_id' => $editora3->id,
            'bibliografia' => 'Obra poética sobre a identidade portuguesa.',
            'capa' => 'capas/mensagem.jpg',
            'preco' => 14.00,
            'estado' => 'disponivel',
            'pdf' => 'pdfs/mensagem.pdf'
        ]);

        $livro3->autores()->attach($autor3->id);
    }
}
