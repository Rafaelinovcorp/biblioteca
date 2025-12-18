<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class RequisicaoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cidadao_nao_pode_aceder_a_rotas_admin()
    {
        // criar utilizador cidadão
        $user = User::factory()->create([
            'role' => 'cidadao',
        ]);

        // autenticar
        $response = $this->actingAs($user)
            ->get('/autores');

        // verificar acesso negado
        $response->assertStatus(403);
    }
}
