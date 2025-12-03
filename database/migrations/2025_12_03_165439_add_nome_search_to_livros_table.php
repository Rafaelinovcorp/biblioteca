<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // só adiciona se não existir
        if (! Schema::hasColumn('livros', 'nome_search')) {
            Schema::table('livros', function (Blueprint $table) {
                $table->string('nome_search')->nullable()->index();
            });
        }
    }

    public function down()
    {
        // só remove se existir
        if (Schema::hasColumn('livros', 'nome_search')) {
            Schema::table('livros', function (Blueprint $table) {
                $table->dropColumn('nome_search');
            });
        }
    }
};
