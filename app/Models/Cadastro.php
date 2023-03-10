<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'email',
        'telefone',
        'has_corretora',
        'nome_corretora',
        'nr_conta_corretora',
        'use_metatrader',
        'has_auth_use_metatrader',
        'mercado',
        'zenitelic_id',
        'cpf'
    ];

    protected $table = 'cadastros';

    public function registro()
    {
        return $this->hasOne(Registro::class, 'ID_usuario', 'zenitelic_id');
    }
}
