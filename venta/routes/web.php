<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;
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
// lista de productos
Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');

// formulario productos
Route::get('/productos/Nueva', [ProductosController::class, 'create'])->name('productos.create');

// guardar productos
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');

// eliminar productos
Route::delete('/productos/{id}', [ProductosController::class, 'delete'])->name('productos.delete');

// editar productos
Route::get('/productos/{producto}/edit',[ ProductosController::class, 'edit'])->name('productos.edit');

// actualizar cambios productos
Route::put('/productos/{id}/edit', [ProductosController::class, 'update'])->name('productos.update');


// lista de categorias
Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');

// formulario categorias
Route::get('/categorias/Nueva', [CategoriasController::class, 'create'])->name('categorias.create');

// guardar categorias
Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');

// eliminar categorias
Route::delete('/categorias/{id}', [CategoriasController::class, 'delete'])->name('categorias.delete');

// editar categorias
Route::get('/categorias/{categoria}/edit',[ CategoriasController::class, 'edit'])->name('categorias.edit');

// actualizar cambios categorias
Route::put('/categorias/{id}/edit', [CategoriasController::class, 'update'])->name('categorias.update');


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

