<?php

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('authentication-failed', function () {
    $errors = [];
    array_push($errors, ['code' => 'auth-001', 'message' => 'Unauthenticated.']);
    return response()->json([
        'errors' => $errors,
    ], 401);
})->name('authentication-failed');

Route::get('register', function () {
    return redirect('login');
});

Route::get('home', function () {
    return redirect('admin');
});

Route::get('admin', function () {
    return redirect('admin');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ($router) {
    $router->get('/', [DashboardController::class, 'index'])->name('dashboard');

    $router->group(['prefix' => 'book', 'as' => 'book.'], function ($router) {
        $router->get('/', [BookController::class, 'index'])->name('list');
        $router->get('available', [BookController::class, 'available'])->name('available');
        $router->get('/create', [BookController::class, 'create'])->name('create');
        $router->post('/create', [BookController::class, 'store'])->name('store');
        $router->get('/edit/{slug}', [BookController::class, 'edit'])->name('edit');
        $router->put('/edit/{slug}', [BookController::class, 'update'])->name('update');
        $router->delete('/destroy/{slug}', [BookController::class, 'destroy'])->name('destroy');
    });

    $router->group(['prefix' => 'users', 'as' => 'users.'], function ($router) {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('{id}', [UserController::class, 'show'])->name('show');
    });

    $router->group(['prefix' => 'report', 'as' => 'report.'], function ($router) {
        Route::get('current', [ReportController::class, 'currentBorrowedBooks'])->name('current');
        Route::get('history', [ReportController::class, 'borrowHistory'])->name('history');
        Route::post('{id}/return', [ReportController::class, 'markAsReturned'])->name('return');
    });

});
