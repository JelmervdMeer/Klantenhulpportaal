<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;


Route::post('/register', [
    AuthController::class,
    'register'
]);

Route::post('/login', [
    AuthController::class,
    'login'
]);

Route::post('/forgot-password', [
    AuthController::class,
    'forgotPassword'
]);

Route::post('/reset-password', [
    AuthController::class,
    'resetPassword'
]);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);

    Route::get('/user', [
        AuthController::class,
        'user'
    ]);

    Route::get('/tickets', [
        TicketController::class,
        'index'
    ]);

    Route::get('/tickets/{ticket}', [
    TicketController::class,
    'show'
]);

Route::get('/tickets', [
    TicketController::class,
    'index'
]);

Route::get('/tickets/{ticket}', [
    TicketController::class,
    'show'
]);

Route::post('/tickets/{ticket}/reactions', [
    TicketController::class,
    'storeReaction'
]);

});

