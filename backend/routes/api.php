<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ReactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


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

Route::get(
    '/email/verify/{id}/{hash}',
    function (EmailVerificationRequest $request) {

        $request->fulfill();

        return response()->json([
            'message' => 'Email succesvol bevestigd.'
        ]);

    }
)
->middleware(['auth:sanctum', 'signed'])
->name('verification.verify');

Route::put('/tickets/{ticket}/status', [
    TicketController::class,
    'updateStatus'
]);
Route::get('/tickets', [
    TicketController::class,
    'index'
]);

Route::put(
    'tickets/{ticket}/priority',
    [TicketController::class, 'updatePriority']
);

Route::get('/tickets/{ticket}', [
    TicketController::class,
    'show'
]);

Route::post('/tickets/{ticket}/reactions', [
    TicketController::class,
    'storeReaction'
]);

Route::post('/tickets', [
    TicketController::class,
    'store'
]);

Route::get('/categories', [
    CategoryController::class,
    'index'
]);

Route::get('/admins', [UserController::class, 'admins']);

Route::put(
    'tickets/{ticket}/assign',
    [TicketController::class, 'assign']
);

Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/categories', [CategoryController::class, 'store']);

Route::put('/categories/{category}', [CategoryController::class, 'update']);

Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::get(
    '/tickets/{ticket}/notes',
    [NoteController::class, 'index']
);


Route::post(
    '/tickets/{ticket}/notes',
    [NoteController::class, 'store']
);


Route::put(
    '/notes/{note}',
    [NoteController::class, 'update']
);


Route::delete(
    '/notes/{note}',
    [NoteController::class, 'destroy']
);

Route::get('/users', [UserController::class, 'index']);

Route::put('/users/{user}', [UserController::class, 'update']);

Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::put(
    '/reactions/{reaction}',
    [ReactionController::class, 'update']
);



});

