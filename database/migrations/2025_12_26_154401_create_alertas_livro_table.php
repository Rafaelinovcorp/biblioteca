<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alertas_livro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('livro_id')->constrained()->cascadeOnDelete();
            $table->boolean('notificado')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'livro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas_livro');
    }
};
