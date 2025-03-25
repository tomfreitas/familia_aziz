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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); // Relacionamento com usuários
            $table->integer('melhor_dia_oferta'); // Dia do mês (1-31)
            $table->string('forma_pgto'); // Forma de pagamento (ex.: cartão, boleto)
            $table->date('data_pgto'); // Data do pagamento
            $table->decimal('valor', 10, 2); // Valor da contribuição
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
