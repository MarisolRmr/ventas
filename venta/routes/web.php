<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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

//Dashboard
Route::get('/', [HomeController::class, 'home'])->name('home');

// Iniciar Sesión
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'store'])->name('login.store');

// Registrarse
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'store_register'])->name('register.store');

// Cerrar sesión
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Dasboard administrador
Route::get('/{user:username}', [DashboardController::class, 'index'])->name('posts.index');