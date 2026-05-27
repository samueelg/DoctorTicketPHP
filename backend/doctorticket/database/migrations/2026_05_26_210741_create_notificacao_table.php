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
        Schema::create('Notificacao', function (Blueprint $table) {
            $table->id('idNotificacao');
            $table->foreignId('idUsuario')
                ->constrained('Usuario')
                ->onDelete('cascade');
            $table->string('titulo');
            $table->text('mensagem');
            $table->string('tipo')->nullable();
            $table->timestamp('lida_em')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Notificacao');
    }
};
