<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'CPF',
        'Nome',
        'Login',
        'Data_inicial',
        'Data_limite',
        'Data_ult_ent',
        'Contador',
        'Origem_registro',
        'Cod_admin',
        'Email',
        'Telefone',
    ];

    protected $primaryKey = 'ID_usuario';

    protected $table = 'ZeniteLic';

    public $timestamps = false;

}
