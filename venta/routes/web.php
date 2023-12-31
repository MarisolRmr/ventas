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
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\CotizacionesController;
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

Route::get('/productos/importar', [ProductosController::class, 'importar_form'])->name('productos.import-form');
Route::post('/productos/importar', [ProductosController::class, 'importar'])->name('productos.importar');

// formulario productos
Route::get('/productos/Nueva', [ProductosController::class, 'create'])->name('productos.create');

// guardar productos
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');

// eliminar productos
Route::put('/productos/{id}', [ProductosController::class, 'activo'])->name('productos.activo');

// editar productos
Route::get('/productos/{producto}/edit',[ ProductosController::class, 'edit'])->name('productos.edit');

// editar productos
Route::get('/productos/{producto}/detalles',[ ProductosController::class, 'detalles'])->name('productos.detalles');

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
Route::put('/categorias/{id}', [CategoriasController::class, 'delete'])->name('categorias.delete');

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
Route::put('/subcategorias/{id}', [SubcategoriaController::class, 'delete'])->name('subcategorias.delete');



// crear devoluciones
Route::get('/get-products/{ventaId}', [DevolucionesController::class, 'buscarVenta'])->name('devoluciones.buscar');

// lista de devoluciones
Route::get('/devoluciones', [DevolucionesController::class, 'index'])->name('devoluciones.index');

// formulario de devoluciones
Route::get('/devoluciones/Nueva', [DevolucionesController::class, 'create'])->name('devoluciones.create');

// guardar devoluciones
Route::post('/devoluciones', [DevolucionesController::class, 'store'])->name('devoluciones.store');


// actualizar cambios subcategorias
Route::put('/devoluciones/{id}/edit', [DevolucionesController::class, 'update'])->name('devoluciones.update');

// eliminar subcategorias
Route::delete('/devoluciones/{id}', [DevolucionesController::class, 'delete'])->name('devoluciones.delete');

// lista de marcas
Route::get('/marcas', [MarcasController::class, 'index'])->name('marcas.index');

// formulario marcas
Route::get('/marcas/Nueva', [MarcasController::class, 'create'])->name('marcas.create');

// guardar marcas
Route::post('/marcas', [MarcasController::class, 'store'])->name('marcas.store');

// eliminar marcas
Route::put('/marcas/{id}', [MarcasController::class, 'activo'])->name('marcas.delete');

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


// guardar ventas
Route::post('/ventas/create', [VentasController::class, 'store'])->name('ventas.store');

// para obtener la subcategoria de una categoria
Route::get('/ventas/subcategorias/{id}', [VentasController::class, 'subcategorias'])->name('ventas.subcategorias');
//para filtrar los productos por categoria o subcategorias
Route::get('/ventas/productosPorCategoria/{id}', [VentasController::class, 'productosPorCategoria'])->name('ventas.productosPorCategoria');
Route::get('/ventas/productosPorSubcategoria/{id}', [VentasController::class, 'productosPorSubcategoria'])->name('ventas.productosPorSubcategoria');
// Ruta para obtener todos los productos
Route::get('/ventas/productosTodos', [VentasController::class, 'productosTodos'])->name('ventas.productosTodos');

// lista de ventas
Route::get('/ventas/{id}/detalle', [VentasController::class, 'detalles_index'])->name('ventas.detalles');


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


// lista de compras
Route::get('/compras', [ComprasController::class, 'index'])->name('compras.index');

// formulario compras
Route::get('/compras/Nueva', [ComprasController::class, 'create'])->name('compras.create');

// guardar compras
Route::post('/compras', [ComprasController::class, 'store'])->name('compras.store');

// validar producto de compras
Route::post('/validar', [ComprasController::class, 'validar'])->name('compras.validar');

// editar compras
Route::get('/compras/{compra}/edit',[ ComprasController::class, 'edit'])->name('compras.edit');

// actualizar cambios compras
Route::put('/compras/{id}/edit', [ComprasController::class, 'update'])->name('compras.update');

// eliminar compras
Route::delete('/compras/{id}', [ComprasController::class, 'delete'])->name('compras.delete');
// lista de compras
Route::get('/compras/{id}/detalle', [ComprasController::class, 'detalles_index'])->name('compras.detalles');


// lista de cotizaciones
Route::get('/cotizaciones', [CotizacionesController::class, 'index'])->name('cotizaciones.index');

// formulario cotizaciones
Route::get('/cotizaciones/Nueva', [CotizacionesController::class, 'create'])->name('cotizaciones.create');

// guardar cotizaciones
Route::post('/cotizaciones', [CotizacionesController::class, 'store'])->name('cotizaciones.store');

// validar producto de cotizaciones
Route::post('/validar', [CotizacionesController::class, 'validar'])->name('cotizaciones.validar');

// editar cotizaciones
Route::get('/cotizaciones/{cotizacion}/edit',[ CotizacionesController::class, 'edit'])->name('cotizaciones.edit');

// actualizar cambios cotizaciones
Route::put('/cotizaciones/{cotizacion}/edit', [CotizacionesController::class, 'update'])->name('cotizaciones.update');

// eliminar cotizaciones
Route::delete('/cotizaciones/{id}', [CotizacionesController::class, 'delete'])->name('cotizaciones.delete');
// lista de cotizaciones
Route::get('/cotizaciones/{id}/detalle', [CotizacionesController::class, 'detalles_index'])->name('cotizaciones.detalles');


// lista de proveedores
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

// formulario usuarios
Route::get('/usuarios/Nueva', [UserController::class, 'create'])->name('usuarios.create');

// guardar usuarios
Route::post('/usuarios', [UserController::class, 'store_user'])->name('usuarios.store');

// editar usuarios
Route::get('/usuarios/{usuario}/edit',[ UserController::class, 'edit'])->name('usuarios.edit');

// actualizar cambios usuarios
Route::put('/usuarios/{id}/update', [UserController::class, 'update'])->name('usuarios.update');

// eliminar usuarios
Route::post('/usuarios/{id}', [UserController::class, 'delete'])->name('usuarios.delete');

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

