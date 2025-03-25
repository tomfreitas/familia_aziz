<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacao extends Model
{
    use HasFactory;

    protected $table = 'observacoes'; // Nome correto da tabela

    protected $fillable = ['user_id', 'observacao'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function respostas()
    {
        return $this->hasMany(Resposta::class)->orderBy('id', 'desc');
    }
}

