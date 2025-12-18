<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleBooksController;
use App\Http\Controllers\RelatorioController;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('livros.index');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rotas protegidas por AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LIVROS (permissões controladas no controller)
    |--------------------------------------------------------------------------
    */
    Route::resource('livros', LivroController::class);

    /*
    |--------------------------------------------------------------------------
    | REQUISIÇÕES
    |--------------------------------------------------------------------------
    */
    Route::resource('requisicoes', RequisicaoController::class)
        ->except(['destroy']);

    Route::post('/requisicoes/{id}/confirmar',
        [RequisicaoController::class, 'confirmar']
    )->name('requisicoes.confirmar');

    Route::post('/requisicoes/{id}/devolver',
        [RequisicaoController::class, 'devolver']
    )->name('requisicoes.devolver');

    /*
    |--------------------------------------------------------------------------
    | ÁREAS APENAS ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        Route::resource('autores', AutorController::class);

        Route::resource('editoras', EditoraController::class);

        Route::resource('users', UserController::class);

        Route::get('/google-books',
            [GoogleBooksController::class, 'index']
        )->name('google-books.index');

        Route::post('/google-books/search',
            [GoogleBooksController::class, 'search']
        )->name('google-books.search');

        Route::post('/google-books/import/{volumeId}',
            [GoogleBooksController::class, 'import']
        )->name('google-books.import');

        Route::get('/relatorios',
            [RelatorioController::class, 'index']
        )->name('relatorios.index');

        Route::post('/relatorios/pdf',
            [RelatorioController::class, 'gerar']
        )->name('relatorios.gerar');
    });
});
