<?php

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
        $router->get('/create', [BookController::class, 'create'])->name('create');
        $router->post('/create', [BookController::class, 'store'])->name('store');
        $router->get('/edit/{slug}', [BookController::class, 'edit'])->name('edit');
        $router->put('/edit/{slug}', [BookController::class, 'update'])->name('update');
        $router->delete('/destroy/{slug}', [BookController::class, 'destroy'])->name('destroy');
    });
});
