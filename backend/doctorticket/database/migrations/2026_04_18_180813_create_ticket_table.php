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
        Schema::create('Ticket', function (Blueprint $table) {
            $table->id('idTicket');
            $table->string('titulo');
            $table->string('assunto');
            $table->date('data_conclusao')->nullable(true);
            $table->string('status');
            $table->foreignId('idUsuario')->constrained('Usuario')->onDelete('cascade');
            $table->string('categoria');
            $table->string('solicitante');
            $table->string('urgencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Ticket');
    }
};
