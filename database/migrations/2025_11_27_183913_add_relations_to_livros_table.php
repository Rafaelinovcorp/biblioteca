<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            // NÃO voltamos a criar 'ano' porque já existe

            // Adiciona autor_id se ainda não existir
            if (!Schema::hasColumn('livros', 'autor_id')) {
                $table->foreignId('autor_id')
                    ->nullable() // deixa nullable para não rebentar em BD já com dados
                    ->constrained('autores')
                    ->after('preco');
            }

            // Adiciona editora_id se ainda não existir
            if (!Schema::hasColumn('livros', 'editora_id')) {
                $table->foreignId('editora_id')
                    ->nullable()
                    ->constrained('editoras')
                    ->after('autor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('livros', function (Blueprint $table) {
            if (Schema::hasColumn('livros', 'autor_id')) {
                $table->dropForeign(['autor_id']);
                $table->dropColumn('autor_id');
            }

            if (Schema::hasColumn('livros', 'editora_id')) {
                $table->dropForeign(['editora_id']);
                $table->dropColumn('editora_id');
            }
        });
    }
};
