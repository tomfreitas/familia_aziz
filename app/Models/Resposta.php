<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    protected $fillable = ['observacao_id', 'resposta'];

    public function observacao()
    {
        return $this->belongsTo(Observacao::class);
    }
}


