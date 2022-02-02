<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('registros', RegistroController::class);

/* Route::get('/registros', [RegistroController::class, 'index']);

Route::get('/registros/novo', [RegistroController::class, 'create']);

Route::post('/registros/adiciona', [RegistroController::class, 'store']); */

/* Route::get('/militares/altera/{id}', 'MilitarController@altera')->where('id','[0-9]+'); */

require __DIR__.'/auth.php';
