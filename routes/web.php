<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public profile routes
Route::get('/{user:username}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/{user:username}/link/{link}', [ProfileController::class, 'redirect'])->name('profile.link');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Links management
    Route::resource('links', LinksController::class);
    Route::post('/links/reorder', [LinksController::class, 'updateOrder'])->name('links.reorder');
});

require __DIR__.'/auth.php';