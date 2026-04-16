<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client;
use App\Http\Controllers\Admin;

Route::get('/', function () {
    return redirect('/client/home');
});

// Auth routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Client routes (middleware: auth, client)
Route::prefix('client')->middleware(['auth', 'client'])->group(function () {
    Route::get('/home', [Client\HomeController::class, 'index'])->name('client.home');
    Route::get('/produits', [Client\ProduitController::class, 'index'])->name('client.produits.index');
    Route::get('/produits/{id}', [Client\ProduitController::class, 'show'])->name('client.produits.show');
    Route::get('/panier', [Client\PanierController::class, 'index'])->name('client.panier.index');
    Route::post('/panier/ajouter', [Client\PanierController::class, 'ajouter'])->name('client.panier.ajouter');
    Route::put('/panier/modifier/{id}', [Client\PanierController::class, 'modifier'])->name('client.panier.modifier');
    Route::delete('/panier/supprimer/{id}', [Client\PanierController::class, 'supprimer'])->name('client.panier.supprimer');
    Route::post('/commande/valider', [Client\CommandeController::class, 'valider'])->name('client.commande.valider');
    Route::get('/commandes', [Client\CommandeController::class, 'index'])->name('client.commandes.index');
    Route::get('/commandes/{id}', [Client\CommandeController::class, 'show'])->name('client.commandes.show');
    Route::get('/souhaits', [Client\SouhaitsController::class, 'index'])->name('client.souhaits.index');
    Route::post('/souhaits/ajouter/{id}', [Client\SouhaitsController::class, 'ajouter'])->name('client.souhaits.ajouter');
    Route::delete('/souhaits/supprimer/{id}', [Client\SouhaitsController::class, 'supprimer'])->name('client.souhaits.supprimer');
});

// Admin routes (middleware: auth, admin)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/produits', Admin\ProduitController::class);
    Route::resource('/categories', Admin\CategorieController::class);
    Route::get('/clients', [Admin\ClientController::class, 'index'])->name('admin.clients.index');
    Route::delete('/clients/{id}', [Admin\ClientController::class, 'destroy'])->name('admin.clients.destroy');
    Route::get('/commandes', [Admin\CommandeController::class, 'index'])->name('admin.commandes.index');
    Route::get('/commandes/{id}', [Admin\CommandeController::class, 'show'])->name('admin.commandes.show');
    Route::put('/commandes/{id}/statut', [Admin\CommandeController::class, 'updateStatut'])->name('admin.commandes.updateStatut');
    Route::get('/rapports', [Admin\RapportController::class, 'index'])->name('admin.rapports.index');
});

// Standard Breeze Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
