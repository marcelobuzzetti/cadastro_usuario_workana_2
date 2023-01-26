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

Route::get('/', function () {
    return redirect('/registros');
});

Route::get('/inativo', function () {
    return view('inactive');
})->name('inativo');

Route::group(['middleware' => ['auth']], function() {
    
    Route::get('/usuarios/inativos', [UsuarioController::class, 'inativos'])->middleware(['acl'])->name('inativos');
    Route::put('/usuarios/ativar', [UsuarioController::class, 'ativar'])->middleware(['acl'])->name('ativar');
    Route::resource('registros', RegistroController::class);
    Route::resource('usuarios', UsuarioController::class)->middleware(['acl']);

});

require __DIR__.'/auth.php';
