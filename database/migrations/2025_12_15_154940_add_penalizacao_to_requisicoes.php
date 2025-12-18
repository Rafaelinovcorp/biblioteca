<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('requisicoes', function (Blueprint $table) {
    $table->integer('dias_atraso')->default(0);
    $table->decimal('penalizacao', 8, 2)->default(0);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            //
        });
    }
};
