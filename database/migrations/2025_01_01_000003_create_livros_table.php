<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('isbn')->nullable()->index();
            $table->string('nome');
            $table->foreignId('editora_id')->constrained('editoras')->cascadeOnDelete();
            $table->text('bibliografia')->nullable();
            $table->string('capa')->nullable();
            $table->decimal('preco', 10, 2)->nullable();
            $table->enum('estado', ['disponivel','ocupado'])->default('disponivel');
            $table->string('pdf')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('livros');
    }
};
