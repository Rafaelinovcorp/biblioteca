<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Livro;
use App\Models\Requisicao;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('permite a um utilizador criar uma requisição de livro', function () {

    //  Criar utilizador
    $user = User::factory()->create([
        'role' => 'cidadao',
    ]);

    //  Criar livro disponível
    $livro = Livro::factory()->create([
        'estado' => 'disponivel',
    ]);

    //  Autenticar utilizador
    $this->actingAs($user);

    //  Submeter requisição
    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    //  Verificar redirecionamento
    $response->assertRedirect(route('requisicoes.index'));

    //  Verificar requisição criada
    $this->assertDatabaseHas('requisicoes', [
        'user_id' => $user->id,
        'livro_id' => $livro->id,
        'estado' => 'pendente',
    ]);

    //  Verificar que o livro ficou ocupado
    $this->assertDatabaseHas('livros', [
        'id' => $livro->id,
        'estado' => 'ocupado',
    ]);
});

it('não permite criar uma requisição sem um livro válido', function () {

    // Criar utilizador
    $user = User::factory()->create([
        'role' => 'cidadao',
    ]);

    // Autenticar utilizador
    $this->actingAs($user);

    // Submeter requisição SEM livro_id
    $response = $this->post(route('requisicoes.store'), []);

    // Deve redirecionar de volta (validação falhou)
    $response->assertStatus(302);

    // Deve existir erro de validação para livro_id
    $response->assertSessionHasErrors('livro_id');

    // Garantir que NENHUMA requisição foi criada
    $this->assertDatabaseCount('requisicoes', 0);
});

it('permite a um utilizador pedir devolução de um livro', function () {

    $user = User::factory()->create([
        'role' => 'cidadao',
    ]);

    $livro = Livro::factory()->create([
        'estado' => 'ocupado',
    ]);

    $requisicao = Requisicao::factory()->create([
        'user_id' => $user->id,
        'livro_id' => $livro->id,
        'estado' => 'confirmado',
    ]);

    $this->actingAs($user);

    $response = $this->post(
        route('requisicoes.pedirDevolucao', $requisicao)
    );

    $response->assertRedirect();

    $this->assertDatabaseHas('requisicoes', [
        'id' => $requisicao->id,
        'estado' => 'devolucao_pedida',
    ]);
});

it('lista apenas as requisições do utilizador autenticado', function () {

    $user1 = User::factory()->create(['role' => 'cidadao']);
    $user2 = User::factory()->create(['role' => 'cidadao']);

    $livro1 = Livro::factory()->create();
    $livro2 = Livro::factory()->create();

    Requisicao::factory()->create([
        'user_id' => $user1->id,
        'livro_id' => $livro1->id,
    ]);

    Requisicao::factory()->create([
        'user_id' => $user2->id,
        'livro_id' => $livro2->id,
    ]);

    $this->actingAs($user1);

    $response = $this->get(route('requisicoes.index'));

    $response->assertStatus(200);

    $response->assertSee($livro1->nome);
    $response->assertDontSee($livro2->nome);
});
it('impede requisitar um livro que não está disponível', function () {

    $user = User::factory()->create([
        'role' => 'cidadao',
    ]);

    $livro = Livro::factory()->create([
        'estado' => 'ocupado',
    ]);

    $this->actingAs($user);

    $response = $this->post(route('requisicoes.store'), [
        'livro_id' => $livro->id,
    ]);

    $response->assertSessionHasErrors('livro_id');

    $this->assertDatabaseCount('requisicoes', 0);
});

