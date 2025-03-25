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
            $table->string('email')->unique()->nullable();
            $table->string('país');
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('celular')->nullable();
            $table->date('data_mantenedor');
            $table->integer('comunicacao_enviada');
            $table->dateTime('comunicacao_enviada_em');
            $table->integer('categoria');
            $table->integer('melhor_dia')->nullable();
            $table->date('aniversário')->nullable();
            $table->string('username');
            $table->string('password');
            $table->integer('type_user');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
