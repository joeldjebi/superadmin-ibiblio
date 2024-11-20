<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\TypePublicationController;
use App\Http\Controllers\DeviseController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\EditeurController;
use App\Http\Controllers\ForfaitController;
use App\Http\Controllers\LivreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => ['auth']], function (){

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
    
    Route::get('/les-auteurs', [AuteurController::class, 'index'])->name('auteur.index');
    Route::post('/store-auteurs', [AuteurController::class, 'store'])->name('auteur.store');
    Route::post('/update-auteurs/{id}', [AuteurController::class, 'update'])->name('auteur.update');
    Route::delete('/destroy-auteurs/{id}', [AuteurController::class, 'destroy'])->name('auteur.destroy');
    
    Route::get('/les-categories-de-livre', [CategorieController::class, 'index'])->name('categorie-livre.index');
    Route::post('/store-categorie-livre', [CategorieController::class, 'store'])->name('categorie-livre.store');
    Route::post('/update-categorie-livre/{id}', [CategorieController::class, 'update'])->name('categorie-livre.update');
    Route::delete('/destroy-categorie-livre/{id}', [CategorieController::class, 'destroy'])->name('categorie-livre.destroy');
    
    Route::get('/les-type-de-publications', [TypePublicationController::class, 'index'])->name('type-de-publication.index');
    Route::post('/store-type-de-publication', [TypePublicationController::class, 'store'])->name('type-de-publication.store');
    Route::post('/update-type-de-publication/{id}', [TypePublicationController::class, 'update'])->name('type-de-publication.update');
    Route::delete('/destroy-type-de-publication/{id}', [TypePublicationController::class, 'destroy'])->name('type-de-publication.destroy');
    
    Route::get('/liste-des-devises', [DeviseController::class, 'index'])->name('devise.index');
    Route::post('/store-devise', [DeviseController::class, 'store'])->name('devise.store');
    Route::post('/update-devise/{id}', [DeviseController::class, 'update'])->name('devise.update');
    Route::delete('/destroy-devise/{id}', [DeviseController::class, 'destroy'])->name('devise.destroy');
    
    Route::get('/liste-des-pays', [PaysController::class, 'index'])->name('pays.index');
    Route::post('/store-pays', [PaysController::class, 'store'])->name('pays.store');
    Route::post('/update-pays/{id}', [PaysController::class, 'update'])->name('pays.update');
    Route::delete('/destroy-pays/{id}', [PaysController::class, 'destroy'])->name('pays.destroy');
    
    Route::get('/liste-des-langues', [LangueController::class, 'index'])->name('langue.index');
    Route::post('/store-langue', [LangueController::class, 'store'])->name('langue.store');
    Route::post('/update-langue/{id}', [LangueController::class, 'update'])->name('langue.update');
    Route::delete('/destroy-langue/{id}', [LangueController::class, 'destroy'])->name('langue.destroy');
    
    Route::get('/liste-des-editeurs', [EditeurController::class, 'index'])->name('editeur.index');
    Route::post('/store-editeur', [EditeurController::class, 'store'])->name('editeur.store');
    Route::post('/update-editeur/{id}', [EditeurController::class, 'update'])->name('editeur.update');
    Route::delete('/destroy-editeur/{id}', [EditeurController::class, 'destroy'])->name('editeur.destroy');
    
    Route::get('/liste-des-forfaits', [ForfaitController::class, 'index'])->name('forfait.index');
    Route::post('/store-forfait', [ForfaitController::class, 'store'])->name('forfait.store');
    Route::post('/update-forfait/{id}', [ForfaitController::class, 'update'])->name('forfait.update');
    Route::delete('/destroy-forfait/{id}', [ForfaitController::class, 'destroy'])->name('forfait.destroy');
    
    Route::get('/liste-des-livres', [LivreController::class, 'index'])->name('livre.index');
    Route::get('/create-livre', [LivreController::class, 'create'])->name('livre.create');
    Route::get('/edit-livre/{id}', [LivreController::class, 'edit'])->name('livre.edit');
    Route::post('/store-livre', [LivreController::class, 'store'])->name('livre.store');
    Route::post('/update-livre/{id}', [LivreController::class, 'update'])->name('livre.update');
    Route::delete('/destroy-livre/{id}', [LivreController::class, 'destroy'])->name('livre.destroy');



});

Route::get('/', [AuthController::class, 'showlogin'])->name('login');

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('logins');

Route::get('/register', [AuthController::class, 'showregister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('registers');