<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleBooksController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AlertaLivroController;

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
    | LIVROS
    |--------------------------------------------------------------------------
    */
    Route::resource('livros', LivroController::class);

    /*
    |--------------------------------------------------------------------------
    | REQUISIÇÕES
    |--------------------------------------------------------------------------
    */
    Route::resource('requisicoes', RequisicaoController::class)
        ->parameters([
            'requisicoes' => 'requisicao',
        ])
        ->except(['destroy']);

        Route::get('/requisicoes/{requisicao}/download', [
    RequisicaoController::class,
    'download'
])->name('requisicoes.download');



Route::post('/alertas-livro', [AlertaLivroController::class, 'store'])
    ->name('alertas.store');



    /*
    |--------------------------------------------------------------------------
    | AÇÕES ADMIN (REQUISIÇÕES)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // Confirmar requisição
        Route::post('/requisicoes/{requisicao}/confirmar', [
            RequisicaoController::class,
            'confirmar'
        ])->name('requisicoes.confirmar');

        // Negar requisição
        Route::post('/requisicoes/{requisicao}/negar', [
            RequisicaoController::class,
            'negar'
        ])->name('requisicoes.negar');

        // Aceitar devolução
        Route::post('/requisicoes/{requisicao}/aceitar-devolucao', [
            RequisicaoController::class,
            'aceitarDevolucao'
        ])->name('requisicoes.aceitarDevolucao');
    });

    /*
    |--------------------------------------------------------------------------
    | AÇÕES CIDADÃO (REQUISIÇÕES)
    |--------------------------------------------------------------------------
    */

    // Cancelar requisição pendente
    Route::post('/requisicoes/{requisicao}/cancelar', [
        RequisicaoController::class,
        'cancelar'
    ])->name('requisicoes.cancelar');

    // Pedir devolução
    Route::post('/requisicoes/{requisicao}/pedir-devolucao', [
        RequisicaoController::class,
        'pedirDevolucao'
    ])->name('requisicoes.pedirDevolucao');

    /*
    |--------------------------------------------------------------------------
    | REVIEWS
    |--------------------------------------------------------------------------
    */

    // Cidadão — criar review (apenas após entrega)
    Route::post('/requisicoes/{requisicao}/reviews', [
        ReviewController::class,
        'store'
    ])->name('reviews.store');

    // Admin — moderação de reviews
    Route::middleware('admin')->group(function () {

        Route::get('/reviews/pendentes', [
            ReviewController::class,
            'pendentes'
        ])->name('reviews.pendentes');

        Route::post('/reviews/{review}/aprovar', [
            ReviewController::class,
            'aprovar'
        ])->name('reviews.aprovar');

        Route::post('/reviews/{review}/recusar', [
            ReviewController::class,
            'recusar'
        ])->name('reviews.recusar');
    });

    /*
    |--------------------------------------------------------------------------
    | ÁREAS APENAS ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // Autores (Route Model Binding PT)
        Route::resource('autores', AutorController::class)
            ->parameters([
                'autores' => 'autor',
            ]);

        Route::resource('editoras', EditoraController::class);
        Route::resource('users', UserController::class);
/*
|--------------------------------------------------------------------------
| GOOGLE BOOKS
|--------------------------------------------------------------------------
*/

Route::get('/google-books', [
    GoogleBooksController::class,
    'index'
])->name('google-books.index');

Route::post('/google-books/search', [
    GoogleBooksController::class,
    'search'
])->name('google-books.search');

/**
 * ECRÃ INTERMÉDIO DE CONFIRMAÇÃO
 */
Route::get('/google-books/confirm/{volumeId}', [
    GoogleBooksController::class,
    'confirm'
])->name('google-books.confirm');

/**
 * IMPORT FINAL (guardar na BD)
 */
Route::post('/google-books/store/{volumeId}', [
    GoogleBooksController::class,
    'store'
])->name('google-books.store');

        /*
        |--------------------------------------------------------------------------
        | RELATÓRIOS
        |--------------------------------------------------------------------------
        */
        Route::get('/relatorios', [
            RelatorioController::class,
            'index'
        ])->name('relatorios.index');

        Route::post('/relatorios/pdf', [
            RelatorioController::class,
            'gerar'
        ])->name('relatorios.gerar');
    });
});
