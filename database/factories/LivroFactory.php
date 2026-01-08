<?php

namespace Database\Factories;

use App\Models\Livro;
use App\Models\Editora;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    protected $model = Livro::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence(3),
            'isbn' => $this->faker->isbn13(),
            'estado' => 'disponivel',
            'preco' => 10,
            'editora_id' => Editora::factory(),
            'categoria_id' => Categoria::factory(),
        ];
    }
}
