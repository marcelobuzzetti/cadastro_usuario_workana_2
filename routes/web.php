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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/usuarios/inativos', [UsuarioController::class, 'inativos'])->middleware(['auth', 'acl']);
Route::put('/usuarios/ativar', [UsuarioController::class, 'ativar'])->middleware(['auth', 'acl']);

Route::resource('registros', RegistroController::class)->middleware(['auth']);
Route::resource('usuarios', UsuarioController::class)->middleware(['auth', 'acl']);

require __DIR__.'/auth.php';
