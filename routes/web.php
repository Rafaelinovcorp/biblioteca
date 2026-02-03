<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    LivroController,
    RequisicaoController,
    ReviewController,
    DashboardController,
    AutorController,
    EditoraController,
    UserController,
    GoogleBooksController,
    RelatorioController,
    AlertaLivroController,
    CarrinhoController,
    CheckoutController,
    OsMeusLivrosController,
    LogController
};

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
| Rotas protegidas por AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Chat
    |--------------------------------------------------------------------------
    */
    Route::get('/chat', fn () => view('chat.index'))
        ->name('chat.index');


    /*
    |--------------------------------------------------------------------------
    | Livros
    |--------------------------------------------------------------------------
    */
    Route::resource('livros', LivroController::class);

    Route::get('/os-meus-livros', [OsMeusLivrosController::class, 'index'])
        ->name('livros.meus');

    /*
    |--------------------------------------------------------------------------
    | Requisições
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

    Route::post('/requisicoes/{requisicao}/cancelar', [
        RequisicaoController::class,
        'cancelar'
    ])->name('requisicoes.cancelar');

    Route::post('/requisicoes/{requisicao}/pedir-devolucao', [
        RequisicaoController::class,
        'pedirDevolucao'
    ])->name('requisicoes.pedirDevolucao');

    /*
    |--------------------------------------------------------------------------
    | Reviews (cidadão)
    |--------------------------------------------------------------------------
    */
    Route::post('/requisicoes/{requisicao}/reviews', [
        ReviewController::class,
        'store'
    ])->name('reviews.store');

    /*
    |--------------------------------------------------------------------------
    | Alertas de livros
    |--------------------------------------------------------------------------
    */
    Route::post('/alertas-livro', [AlertaLivroController::class, 'store'])
        ->name('alertas.store');

    /*
    |--------------------------------------------------------------------------
    | Carrinho
    |--------------------------------------------------------------------------
    */
    Route::get('/carrinho', [CarrinhoController::class, 'index'])
        ->name('carrinho.index');

    Route::post('/carrinho/{livro}', [CarrinhoController::class, 'add'])
        ->name('carrinho.add');

    Route::delete('/carrinho/{livro}', [CarrinhoController::class, 'remove'])
        ->name('carrinho.remove');

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */
    Route::get('/checkout/endereco', fn () => view('checkout.endereco'))
        ->name('checkout.endereco');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])
        ->name('checkout.process');

    Route::get('/checkout/sucesso', fn () => view('checkout.sucesso'))
        ->name('checkout.sucesso');
});

/*
|--------------------------------------------------------------------------
| Rotas APENAS ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logs
    |--------------------------------------------------------------------------
    */
    Route::get('/logs', [LogController::class, 'index'])
        ->name('logs.index');

    Route::get('/logs/{log}', [LogController::class, 'show'])
        ->name('logs.show');

    /*
    |--------------------------------------------------------------------------
    | Requisições (admin)
    |--------------------------------------------------------------------------
    */
    Route::post('/requisicoes/{requisicao}/confirmar', [
        RequisicaoController::class,
        'confirmar'
    ])->name('requisicoes.confirmar');

    Route::post('/requisicoes/{requisicao}/negar', [
        RequisicaoController::class,
        'negar'
    ])->name('requisicoes.negar');

    Route::post('/requisicoes/{requisicao}/aceitar-devolucao', [
        RequisicaoController::class,
        'aceitarDevolucao'
    ])->name('requisicoes.aceitarDevolucao');

    /*
|--------------------------------------------------------------------------
| Chat - Salas (Admin)
|--------------------------------------------------------------------------
*/
Route::get('/chat/salas/criar', function () {
    return view('chat.create-room');
})->name('chat.create-room');


    /*
    |--------------------------------------------------------------------------
    | Reviews (admin)
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Gestão
    |--------------------------------------------------------------------------
    */
    Route::resource('autores', AutorController::class)
        ->parameters([
            'autores' => 'autor',
        ]);

    Route::resource('editoras', EditoraController::class);
    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Google Books
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

    Route::get('/google-books/confirm/{volumeId}', [
        GoogleBooksController::class,
        'confirm'
    ])->name('google-books.confirm');

    Route::post('/google-books/store/{volumeId}', [
        GoogleBooksController::class,
        'store'
    ])->name('google-books.store');

    /*
    |--------------------------------------------------------------------------
    | Relatórios
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
