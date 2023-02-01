<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CadastroController;

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

Route::resource('cadastros', CadastroController::class);

Route::group(['middleware' => ['auth']], function() {

    Route::get('/usuarios/inativos', [UsuarioController::class, 'inativos'])->middleware(['acl'])->name('inativos');
    Route::put('/usuarios/ativar', [UsuarioController::class, 'ativar'])->middleware(['acl'])->name('ativar');
    Route::resource('registros', RegistroController::class);
    Route::resource('usuarios', UsuarioController::class)->middleware(['acl']);

    Route::get('/acessos', [RegistroController::class, 'acessos'])->middleware(['acl'])->name('acessos');
    Route::post('/email', [RegistroController::class, 'email'])->name('email');
    Route::post('/emailcadastro', [CadastroController::class, 'email'])->name('emailcadastro');
    Route::post('/cadastros/zenitlic', [CadastroController::class, 'cadastrozenitelic'])->name('cadastrozenitelic')->middleware(['acl']);
    Route::get('/cadastros/zenitlic/{id}', [CadastroController::class, 'zenitlic'])->name('cadastros.zenitlic')->middleware(['acl']);
    Route::permanentRedirect('/email', '/registros');

    Route::resource('emailMarketing', EmailController::class)->middleware(['acl']);

});

require __DIR__.'/auth.php';
