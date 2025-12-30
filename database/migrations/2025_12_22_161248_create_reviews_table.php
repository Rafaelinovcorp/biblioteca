<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relações
            $table->foreignId('requisicao_id')
                ->constrained('requisicoes')
                ->cascadeOnDelete()
                ->unique(); // 1 review por requisição

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('livro_id')
                ->constrained('livros')
                ->cascadeOnDelete();

            // Conteúdo da review
            $table->tinyInteger('rating')->nullable(); // opcional
            $table->text('comentario');

            // Moderação
            $table->enum('estado', ['pendente', 'ativa', 'recusada'])
                ->default('pendente');

            $table->text('justificacao')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
