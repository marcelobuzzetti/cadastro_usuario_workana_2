<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\CKEditorController;
use Illuminate\Support\Facades\Artisan;

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
    /*return view('cadastro.create');*/
});

/*Route::get('/schedule', function() {
    Artisan::call('schedule:run');
});

Route::get('/retry', function() {
    Artisan::call('queue:retry all');
});*/

Route::get('/teste', [CadastroController::class, 'teste'])->name('teste');

Route::get('/inativo', function () {
    return view('inactive');
})->name('inativo');

Route::resource('cadastros', CadastroController::class);

Route::group(['middleware' => ['auth']], function() {

    Route::group(['middleware' => ['emailAtivacao']], function() {

        Route::get('/usuarios/inativos', [UsuarioController::class, 'inativos'])->middleware(['acl'])->name('inativos');
        Route::put('/usuarios/ativar', [UsuarioController::class, 'ativar'])->middleware(['acl'])->name('ativar');
        Route::resource('registros', RegistroController::class);
        Route::resource('usuarios', UsuarioController::class)->middleware(['acl']);
        Route::get('/acessos', [RegistroController::class, 'acessos'])->middleware(['acl'])->name('acessos');
        Route::post('/email', [RegistroController::class, 'email'])->name('email');
        Route::post('/emailcadastro', [CadastroController::class, 'email'])->name('emailcadastro');
        Route::post('/cadastros/zenitlic', [CadastroController::class, 'cadastrozenitelic'])->name('cadastrozenitelic')->middleware(['acl']);
        Route::get('/cadastros/zenitlic/{id}', [CadastroController::class, 'zenitlic'])->name('cadastros.zenitlic')->middleware(['acl']);
        Route::get('/ativos', [CadastroController::class, 'ativos'])->name('cadastros.ativos')->middleware(['acl']);
        Route::permanentRedirect('/email', '/registros');
        Route::resource('emailMarketing', EmailController::class)->middleware(['acl']);
        Route::get('/relatorio', [RelatorioController::class, 'index'])->name('relatorio');
        Route::post('/relatorio', [RelatorioController::class, 'search'])->name('search');
        Route::post('/naoacessou', [RelatorioController::class, 'naoAcessou'])->name('naoacessou');

    });

    Route::resource('configs', ConfigController::class)->middleware(['acl'])->except([
        'index'
    ]);

    Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.image-upload');

});

require __DIR__.'/auth.php';
