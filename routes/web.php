<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\StatController;

require __DIR__.'/auth.php';

// Redirection après login selon le rôle
Route::get('/redirect-role', function () {
    $role = auth()->user()->role ?? null;

    return match ($role) {
        'gestionnaire' => redirect()->route('dashboard'),
        'client' => redirect()->route('client.burgers'),
        default => redirect('/'),
    };
})->middleware('auth');

// ========================
// Authentification requise
Route::middleware('auth')->group(function () {

    // 👤 Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================
    // 👨‍🍳 Routes GESTIONNAIRE
    Route::middleware('role:gestionnaire')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Statistiques
        Route::get('/stats', [StatController::class, 'index'])->name('stats.index');

        // Burgers
        Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
        Route::get('/burgers/archives', [BurgerController::class, 'archive'])->name('burgers.archive');
        Route::put('/burgers/{id}/archive', [BurgerController::class, 'archiveBurger'])->name('archiveBurger');
        Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
        Route::post('/burgers', [BurgerController::class, 'store'])->name('burgers.store');
        Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
        Route::put('/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');

        /// Commandes 
        Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
        Route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
        Route::put('/commandes/{commande}/status', [CommandeController::class, 'updateStatus'])->name('commandes.updateStatus');
        Route::put('/commandes/{commande}/cancel', [CommandeController::class, 'cancel'])->name('commandes.cancel');
    });

    // ========================
    // 🍔 Routes CLIENT
    Route::middleware('role:client')->group(function () {
        // Affichage du menu burger
        Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index')->middleware('auth');
        Route::get('/menu', [BurgerController::class, 'indexClient'])->name('client.burgers');

        // Panier
        Route::get('/panier', [PanierController::class, 'index'])->name('panier.voir');
        Route::delete('/panier/{id}', [PanierController::class, 'destroy'])->name('panier.destroy');
        Route::post('/panier/valider', [PanierController::class, 'validerPanier'])->name('panier.valider');
        Route::post('/panier/ajouter/{burger}', [PanierController::class, 'store'])->name('panier.ajouter');
        //Route::post('/panier/valider', [CommandeController::class, 'valider'])->name('commandes.valider');

        // Factures
        Route::get('/factures', [FactureController::class, 'index'])->name('facture.index');
        Route::post('/factures', [FactureController::class, 'store'])->name('facture.store');
        Route::get('/factures/{id}', [FactureController::class, 'show'])->name('facture.show');
    });
});
