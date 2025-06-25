<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AlteracaoCardController;
use App\Http\Controllers\PlanilhaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota inicial
Route::get('/', function () {
    return view('welcome');
});

// Autenticação padrão do Laravel
Auth::routes();

// Página principal após login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Perfil
Route::middleware(['auth'])->group(function (){
Route::get('perfil', [PerfilController::class, 'index'])->name('profile.profile');
Route::get('/profile/edit', [PerfilController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [PerfilController::class, 'update'])->name('profile.update');
});

// Rota para exibir a planilha

Route::middleware(['auth'])->group(function () {
Route::get('/planilha', [PlanilhaController::class, 'index'])->name('planilha.index');
Route::post('/planilha', [PlanilhaController::class, 'store'])->name('planilha.store');
Route::get('/planilha/{id}/edit', [PlanilhaController::class, 'edit'])->name('planilha.edit');
Route::put('/planilha/{id}', [PlanilhaController::class, 'updatePlanilhaItem'])->name('planilha.update');
Route::delete('/planilha/{id}', [PlanilhaController::class, 'destroy'])->name('planilha.destroy');
Route::get('/planilha/adicionar', [PlanilhaController::class, 'create'])->name('planilha.add_item');
});

// Rotas para exibir os cards com últimas alterações

Route::middleware(['auth'])->group(function () {
Route::get('/posts', [AlteracaoCardController::class, 'index'])->name('posts.index');
Route::post('/cards/store', [AlteracaoCardController::class, 'storeCard'])->name('cards.store');
Route::get('/cards/edit/{id}', [AlteracaoCardController::class, 'editCard'])->name('cards.edit');
Route::put('/cards/update/{id}', [AlteracaoCardController::class, 'updateCard'])->name('cards.update');
Route::delete('/cards/destroy/{id}', [AlteracaoCardController::class, 'destroyCard'])->name('cards.destroy');
});
