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
        Schema::create('franqueado', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->foreignId('idUnidade')->nullable()->constrained('unidade')->onDelete('cascade');
            $table->string('idMovidesk')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('franqueado_talbe');
    }
};
