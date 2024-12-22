<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\LibraryController;
use App\Http\Controllers\API\UserLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'api'], function () {
    Route::post('/user/login', [UserLoginController::class, 'login']);
    Route::post('/user/register', [UserLoginController::class, 'register']);

    Route::middleware(['auth:api'])->group(function () {
        Route::post('/user/update', [UserLoginController::class, 'updateProfile']);

        Route::prefix('books')->group(function () {
            Route::get('/', [BookController::class, 'index']);
            Route::post('store', [BookController::class, 'store']);
            Route::get('{id}', [BookController::class, 'show']);
            Route::put('edit/{id}', [BookController::class, 'update']);
            Route::delete('delete/{id}', [BookController::class, 'destroy']);
        });

        Route::post('/borrow-book', [LibraryController::class, 'borrowBook']);
        Route::post('/return-book', [LibraryController::class, 'returnBook']);
        Route::post('/update-last-page', [LibraryController::class, 'updateLastPage']);
        Route::get('/available-books', [LibraryController::class, 'availableBooks']);
        Route::get('/current-borrowed-books', [LibraryController::class, 'currentBorrowedBooks']);
        Route::get('/borrowing-history', [LibraryController::class, 'borrowingHistory']);
    });
});
