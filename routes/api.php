<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Api\AuthController;
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

/**
 * Routes for All Visitor
 */
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);

    Route::get('books/{book}/ratings', [RatingController::class, 'index']);
    Route::get('ratings/{rating}', [RatingController::class, 'show']);
/**
 * Routes for all Authentcated Users
 */
Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

});

/**
 * User-specific routes
 */
Route::group(['middleware' => ['auth:api', 'role:user']], function () {
    Route::post('books/{book}/return', [BorrowController::class, 'returnBook']);
    Route::post('books/{book}/borrow', [BorrowController::class, 'borrowBook']);

    Route::get('favourate', [RatingController::class, 'favourate']);
    Route::post('books/{book}/ratings', [RatingController::class, 'store']);
    Route::put('ratings/{rating}', [RatingController::class, 'update']);
    Route::delete('ratings/{rating}', [RatingController::class, 'destroy']);

});

/**
 *  Admin-specific routes
 */
Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{book}', [BookController::class, 'update']);
    Route::delete('books/{book}', [BookController::class, 'destroy']);

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});
