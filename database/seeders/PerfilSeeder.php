<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfils = [
            [
                'perfil' => 'Admin'
            ],
            [
                'perfil' => 'Comum'
            ],
            [
                'perfil' => 'Comum Cadastrador'
            ]
        ];

        foreach ($perfils as &$perfil) {
            Perfil::create($perfil);
        }
    }
}
