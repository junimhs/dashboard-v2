<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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
    return redirect('admin/home');
});

Route::prefix('admin')->middleware(['auth'])->group(function() {
    Route::get('home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});