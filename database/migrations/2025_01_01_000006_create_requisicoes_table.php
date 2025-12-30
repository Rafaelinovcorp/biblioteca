<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numero')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('livro_id')->constrained('livros')->cascadeOnDelete();
            $table->string('foto_cidadao')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim_previsto');
            $table->date('data_fim_real')->nullable();
            $table->integer('dias_decorridos')->nullable();
           $table->string('estado')->default('pendente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('requisicoes');
    }
};
