<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->string('titulo_search')->nullable()->index();
        });

        Schema::table('editoras', function (Blueprint $table) {
            $table->string('nome_search')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::table('livros', function (Blueprint $table) {
            $table->dropColumn('titulo_search');
        });

        Schema::table('editoras', function (Blueprint $table) {
            $table->dropColumn('nome_search');
        });
    }
};
