<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // Relacionamento com usuários
            $table->string('tipo'); // Tipo de notificação (ex.: aniversário, vencimento)
            $table->text('mensagem'); // Mensagem da notificação
            $table->enum('status', ['enviada', 'não enviada'])->default('não enviada'); // Status da notificação
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
