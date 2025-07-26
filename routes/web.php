<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BurgerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🧀 BURGERS (Gestionnaire + Client avec logique dans Blade)
    Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::get('/burgers/create', [BurgerController::class, 'create'])->name('add');
    Route::post('/burgers', [BurgerController::class, 'store'])->name('saveBurger');
    Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('editBurger');
    Route::put('/burgers/{burger}', [BurgerController::class, 'update'])->name('updateBurger');

    // Archivage
    Route::put('/burgers/{id}/archive', [BurgerController::class, 'archiveBurger'])->name('archiveBurger');
    Route::get('/burgers/archives', [BurgerController::class, 'archive'])->name('burgers.archive');
});

require __DIR__.'/auth.php';
