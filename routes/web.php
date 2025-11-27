<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    
    Route::resource('autores', AutorController::class)->parameters([
        'autores' => 'autor', 
    ]);

    Route::get('autores/{autor}/confirm-delete', [AutorController::class, 'confirmDelete'])
    ->name('autores.confirm-delete');


    

    Route::resource('editoras', EditoraController::class);

    Route::get('/editoras/{editora}/confirm-delete', [EditoraController::class, 'confirmDelete'])
    ->name('editoras.confirm-delete');        
});
