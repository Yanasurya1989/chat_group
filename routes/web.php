<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;

// ========== LOGIN PAGE ==========
Route::get('/login', [AuthController::class, 'index'])
    ->name('login')
    ->middleware('guest');

// ========== LOGIN ACTION ==========
Route::post('/login', [AuthController::class, 'authenticate'])
    ->name('login.post');

// ========== LOGOUT ==========
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ========== CHAT (HARUS LOGIN) ==========
Route::middleware('auth')->group(function () {

    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');

    Route::post('/chat/send', [ChatController::class, 'send'])
        ->name('chat.send');
});

// ========== DEFAULT ==========
Route::get('/', function () {
    return redirect('/chat');
});
