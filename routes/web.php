<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login_form');
Route::post('/login', [LoginController::class, 'login'])->name("login");
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register_form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware("auth")->group(function (){
    Route::get('/{any}', function () {
        return view('main');
    })->where('any', '.*');
    Route::get('/', function () {
        return view('main');
    })->name('main');
    Route::resource('categories', CategoryController::class);
    Route::resource('tasks', TaskController::class);
});
