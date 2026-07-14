<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Publieke routes
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Beveiligde routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authenticatie
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ]);

    Route::get('/user', [
        AuthController::class,
        'user'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ]);


    /*
    |--------------------------------------------------------------------------
    | E-mailverificatie
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/email/verify/{id}/{hash}',
        function (EmailVerificationRequest $request) {

            $request->fulfill();

            return response()->json([
                'message' => 'E-mail succesvol bevestigd.'
            ]);

        }
    )
        ->middleware(['signed'])
        ->name('verification.verify');


    /*
    |--------------------------------------------------------------------------
    | Tickets
    |--------------------------------------------------------------------------
    */

    Route::get('/tickets', [
        TicketController::class,
        'index'
    ]);

    Route::post('/tickets', [
        TicketController::class,
        'store'
    ]);

    Route::get('/tickets/{ticket}', [
        TicketController::class,
        'show'
    ]);

    Route::put('/tickets/{ticket}/status', [
        TicketController::class,
        'updateStatus'
    ]);

    Route::put('/tickets/{ticket}/priority', [
        TicketController::class,
        'updatePriority'
    ]);

    Route::put('/tickets/{ticket}/assign', [
        TicketController::class,
        'assign'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Reacties
    |--------------------------------------------------------------------------
    */

    Route::post('/tickets/{ticket}/reactions', [
        TicketController::class,
        'storeReaction'
    ]);

    Route::put('/reactions/{reaction}', [
        ReactionController::class,
        'update'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Categorieën
    |--------------------------------------------------------------------------
    */

    Route::get('/categories', [
        CategoryController::class,
        'index'
    ]);

    Route::post('/categories', [
        CategoryController::class,
        'store'
    ]);

    Route::put('/categories/{category}', [
        CategoryController::class,
        'update'
    ]);

    Route::delete('/categories/{category}', [
        CategoryController::class,
        'destroy'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Notities
    |--------------------------------------------------------------------------
    */

    Route::get('/tickets/{ticket}/notes', [
        NoteController::class,
        'index'
    ]);

    Route::post('/tickets/{ticket}/notes', [
        NoteController::class,
        'store'
    ]);

    Route::put('/notes/{note}', [
        NoteController::class,
        'update'
    ]);

    Route::delete('/notes/{note}', [
        NoteController::class,
        'destroy'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Gebruikers
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [
        UserController::class,
        'index'
    ]);

    Route::get('/admins', [
        UserController::class,
        'admins'
    ]);

    Route::put('/users/{user}', [
        UserController::class,
        'update'
    ]);

    Route::delete('/users/{user}', [
        UserController::class,
        'destroy'
    ]);

});
