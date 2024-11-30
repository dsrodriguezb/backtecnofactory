<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Comics\FavoritoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/signin', [AuthController::class, 'signIn']);
    Route::post('/logout', [AuthController::class, 'logOut']);
    Route::post('/signup', [AuthController::class, 'signUp']);

    Route::middleware('jwt-verify')->group(function () {
        Route::get('/profile/{login}', [AuthController::class, 'show']);
    });
});

Route::prefix('favorites')->group(function () {
    Route::middleware('jwt-verify')->group(function () {
        Route::post('/{comicId}/{usuarioId}', [FavoritoController::class, 'toggleFavorite']);
        Route::get('/{usuarioId}', [FavoritoController::class, 'getFavorites']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
