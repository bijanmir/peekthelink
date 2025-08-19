<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Add this import
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// API routes - Put these FIRST to avoid conflicts
Route::prefix('api')->group(function () {
    Route::post('/check-username', [RegistrationController::class, 'checkUsername']);
    Route::post('/check-email', [RegistrationController::class, 'checkEmail']);
    Route::post('/check-password-strength', [RegistrationController::class, 'checkPasswordStrength']);
    Route::post('/register', [RegistrationController::class, 'register']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']); // Use existing login
    Route::post('/password-reset', function() {
        return response()->json(['success' => true, 'message' => 'Password reset link sent!']);
    }); // Placeholder for now
    
    // Auth check route
    Route::get('/auth-check', function() {
        return response()->json([
            'authenticated' => auth()->check(),
            'user' => auth()->user() ? [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'username' => auth()->user()->username,
                'email' => auth()->user()->email
            ] : null
        ]);
    });
});

// Test route to check if API is working
Route::get('/test-api', function() {
    return response()->json([
        'message' => 'API is working!',
        'csrf' => csrf_token(),
        'auth' => auth()->check(),
        'user' => auth()->user()?->username
    ]);
});

// Authenticated routes - MUST come before public profile routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard/realtime', [DashboardController::class, 'realtimeData'])->name('dashboard.realtime');
    
    // Links management
    Route::resource('links', LinksController::class);
    Route::post('/links/reorder', [LinksController::class, 'updateOrder'])->name('links.reorder');
});

// Auth routes (login, register, etc.)
require __DIR__.'/auth.php';

// DEBUG ROUTES - Test these first
Route::get('/debug/users', function() {
    return \App\Models\User::all(['id', 'username', 'name']);
});

Route::get('/debug/links', function() {
    return \App\Models\Link::with('user:id,username,name')->get();
});

// Simplified redirect route for testing
Route::get('/test-redirect/{userId}/{linkId}', function($userId, $linkId) {
    $user = \App\Models\User::findOrFail($userId);
    $link = \App\Models\Link::findOrFail($linkId);
    
    if ($link->user_id !== $user->id) {
        return "ERROR: Link doesn't belong to user!";
    }
    
    return redirect()->away($link->url);
});

// Public profile routes - MUST come last to avoid conflicts
Route::get('/{user:username}', [ProfileController::class, 'show'])
    ->name('profile.show');

// Simplified link redirect route
Route::get('/{user:username}/link/{link}', [ProfileController::class, 'redirect'])
    ->name('profile.link');