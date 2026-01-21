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
        Schema::table('contributions', function (Blueprint $table) {
            // Remove a foreign key constraint
            $table->dropForeign(['user_id']);

            // Altera user_id para permitir nulo
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Adiciona coluna para guardar o nome do usuário excluído
            $table->string('nome_usuario_excluido')->nullable()->after('user_id');

            // Recria a foreign key permitindo SET NULL on delete
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('nome_usuario_excluido');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
