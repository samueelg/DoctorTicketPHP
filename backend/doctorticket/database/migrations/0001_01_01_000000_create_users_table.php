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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('ramal')->unique();
            $table->string('senha');
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->enum('tipo', ['analista', 'admin']);
            $table->timestamps();
        });

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
