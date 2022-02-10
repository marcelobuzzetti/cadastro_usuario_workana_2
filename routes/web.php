<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain('registro.radarzenite.com.br')->group(function () {

    Route::get('/', function () {
        return redirect('/registros');
    });

    Route::get('/usuarios/inativos', [UsuarioController::class, 'inativos'])->middleware(['auth', 'acl'])->name('inativos');
    Route::put('/usuarios/ativar', [UsuarioController::class, 'ativar'])->middleware(['auth', 'acl'])->name('ativar');

    Route::resource('registros', RegistroController::class)->middleware(['auth']);
    Route::resource('usuarios', UsuarioController::class)->middleware(['auth', 'acl']);
});

require __DIR__ . '/auth.php';
