<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'melhor_dia_oferta',
        'forma_pgto',
        'data_pgto',
        'valor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
