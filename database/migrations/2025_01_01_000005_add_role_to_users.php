<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin','cidadao'])->default('cidadao')->after('password');
            $table->string('foto_perfil')->nullable();
            $table->text('dados_encriptados')->nullable();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','foto_perfil','dados_encriptados']);
        });
    }
};
