<?php

namespace Database\Factories;

use App\Models\Requisicao;
use App\Models\User;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequisicaoFactory extends Factory
{
    protected $model = Requisicao::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'livro_id' => Livro::factory(),
            'estado' => 'pendente',
            'data_inicio' => now(),
            'data_fim_previsto' => now()->addDays(5),
        ];
    }
}
