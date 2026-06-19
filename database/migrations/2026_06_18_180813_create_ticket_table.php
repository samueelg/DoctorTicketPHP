<?php

use App\Models\Usuario;
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
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('assunto');
            $table->date('data_conclusao')->nullable(true);
            $table->string('status');
            $table->foreignId('idUsuario')->constrained('usuario')->onDelete('cascade');
            $table->string('categoria');
            $table->foreignId('solicitante')->constrained('franqueado')->onDelete('cascade');
            $table->string('urgencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
