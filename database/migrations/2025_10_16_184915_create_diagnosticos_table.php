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
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_doenca');
            $table->text('sintomas_chave');
            $table->string('diagnostico_provavel')->nullable();
            $table->enum('condicao_gravidade', ['leve', 'moderada', 'grave'])->default('moderada');
            $table->json('posologias')->nullable();
            $table->json('exames_solicitados')->nullable();
            $table->json('recomendacoes')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos');
    }
};
