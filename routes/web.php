<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\OAuthRedirectController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'user' => auth()->user(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/oauthredirect', OAuthRedirectController::class);
Route::post('/access_token', [AccessTokenController::class, 'store']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
