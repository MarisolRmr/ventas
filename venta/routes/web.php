<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\DevolucionesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProveedoresController;
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

//ruta para enviar datos al servidor de imagen
Route::post('/productos_imagen', [ProductosController::class,'store_imagen'])->name('productos.imagen');

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

// lista de subcategorias
Route::get('/subcategorias', [SubcategoriaController::class, 'index'])->name('subcategorias.index');

// formulario subcategorias
Route::get('/subcategorias/Nueva', [SubcategoriaController::class, 'create'])->name('subcategorias.create');

// guardar subcategorias
Route::post('/subcategorias', [SubcategoriaController::class, 'store'])->name('subcategorias.store');

//ruta para enviar datos al servidor de imagen
Route::post('/subcategorias_imagen', [SubcategoriaController::class,'store_imagen'])->name('subcategorias.imagen');

// editar categorias
Route::get('/subcategorias/{subcategoria}/edit',[ SubcategoriaController::class, 'edit'])->name('subcategorias.edit');

// actualizar cambios subcategorias
Route::put('/subcategorias/{id}/edit', [SubcategoriaController::class, 'update'])->name('subcategorias.update');

// eliminar subcategorias
Route::delete('/subcategorias/{id}', [SubcategoriaController::class, 'delete'])->name('subcategorias.delete');

// lista de marcas
Route::get('/marcas', [MarcasController::class, 'index'])->name('marcas.index');

// formulario marcas
Route::get('/marcas/Nueva', [MarcasController::class, 'create'])->name('marcas.create');

// guardar marcas
Route::post('/marcas', [MarcasController::class, 'store'])->name('marcas.store');

// eliminar marcas
Route::delete('/marcas/{id}', [MarcasController::class, 'delete'])->name('marcas.delete');

// editar marcas
Route::get('/marcas/{marca}/edit',[ MarcasController::class, 'edit'])->name('marcas.edit');

// actualizar cambios marcas
Route::put('/marcas/{id}/edit', [MarcasController::class, 'update'])->name('marcas.update');

//ruta para enviar datos al servidor de imagen
Route::post('/imagenes', [MarcasController::class,'store_imagen'])->name('imagenes.store');

// lista de clientes
Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');

// formulario clientes
Route::get('/clientes/Nueva', [ClientesController::class, 'create'])->name('clientes.create');

// guardar clientes
Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');

// eliminar clientes
Route::delete('/clientes/{id}', [ClientesController::class, 'delete'])->name('clientes.delete');

// editar clientes
Route::get('/clientes/{cliente}/edit',[ ClientesController::class, 'edit'])->name('clientes.edit');

// actualizar cambios clientes
Route::put('/clientes/{id}/edit', [ClientesController::class, 'update'])->name('clientes.update');

// lista de ventas
Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');

// pos de ventas
Route::get('/ventas/Nueva', [VentasController::class, 'create'])->name('ventas.create');

// para obtener la subcategoria de una categoria
Route::get('/ventas/subcategorias/{id}', [VentasController::class, 'subcategorias'])->name('ventas.subcategorias');
//para filtrar los productos por categoria o subcategorias
Route::get('/ventas/productosPorCategoria/{id}', [VentasController::class, 'productosPorCategoria'])->name('ventas.productosPorCategoria');
Route::get('/ventas/productosPorSubcategoria/{id}', [VentasController::class, 'productosPorSubcategoria'])->name('ventas.productosPorSubcategoria');

// guardar ventas
Route::post('/ventas', [VentasController::class, 'store'])->name('ventas.store');

// eliminar ventas
Route::delete('/ventas/{id}', [VentasController::class, 'delete'])->name('ventas.delete');

// editar ventas
Route::get('/ventas/{marca}/edit',[ VentasController::class, 'edit'])->name('ventas.edit');

// actualizar cambios ventas
Route::put('/ventas/{id}/edit', [VentasController::class, 'update'])->name('ventas.update');

// lista de ventas
Route::get('/ventas/detalle', [VentasController::class, 'detalles_index'])->name('ventas.detalles');

// lista de devoluciones
Route::get('/devoluciones', [DevolucionesController::class, 'index'])->name('devoluciones.index');

// lista de proveedores
Route::get('/proveedores', [ProveedoresController::class, 'index'])->name('proveedores.index');

// formulario proveedores
Route::get('/proveedores/Nueva', [ProveedoresController::class, 'create'])->name('proveedores.create');

// guardar proveedores
Route::post('/proveedores', [ProveedoresController::class, 'store'])->name('proveedores.store');

// editar proveedores
Route::get('/proveedores/{proveedor}/edit',[ ProveedoresController::class, 'edit'])->name('proveedores.edit');

// actualizar cambios proveedores
Route::put('/proveedores/{id}/edit', [ProveedoresController::class, 'update'])->name('proveedores.update');

// eliminar proveedores
Route::delete('/proveedores/{id}', [ProveedoresController::class, 'delete'])->name('proveedores.delete');


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

