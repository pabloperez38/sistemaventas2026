<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TmpCompraController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [AdminController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [AdminController::class, 'index'])->name('home')->middleware('auth');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');

//Configuración
Route::get('/admin/configuracion', [ConfiguracionController::class, 'index'])->name('admin.configuracion.index')->middleware('auth');
Route::put('/admin/configuracion', [ConfiguracionController::class, 'update'])->name('admin.configuracion.update')->middleware('auth');

//Roles
Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth');
Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth');
Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth');
Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth');
Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth');

//Usuarios
Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth');
Route::get('/admin/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth');
Route::post('/admin/usuarios', [UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth');
Route::get('/admin/usuarios/{id}', [UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth');
Route::get('/admin/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth');
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth');
Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth');

//Categorias
Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index')->middleware('auth');
Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create')->middleware('auth');
Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store')->middleware('auth');
Route::get('/admin/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('admin.categorias.edit')->middleware('auth');
Route::put('/admin/categorias/{id}', [CategoriaController::class, 'update'])->name('admin.categorias.update')->middleware('auth');
Route::delete('/admin/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy')->middleware('auth');
Route::get('categorias/{id}/restore', [CategoriaController::class, 'restore'])->name('admin.categorias.restore')->middleware('auth');

//Marcas
Route::get('/admin/marcas', [MarcaController::class, 'index'])->name('admin.marcas.index')->middleware('auth');
Route::get('/admin/marcas/create', [MarcaController::class, 'create'])->name('admin.marcas.create')->middleware('auth');
Route::post('/admin/marcas', [MarcaController::class, 'store'])->name('admin.marcas.store')->middleware('auth');
Route::get('/admin/marcas/{id}/edit', [MarcaController::class, 'edit'])->name('admin.marcas.edit')->middleware('auth');
Route::put('/admin/marcas/{id}', [MarcaController::class, 'update'])->name('admin.marcas.update')->middleware('auth');
Route::delete('/admin/marcas/{id}', [MarcaController::class, 'destroy'])->name('admin.marcas.destroy')->middleware('auth');
Route::get('marcas/{id}/restore', [MarcaController::class, 'restore'])->name('admin.marcas.restore')->middleware('auth');


//Productos
Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos.index')->middleware('auth');
Route::get('/admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create')->middleware('auth');
Route::post('/admin/productos', [ProductoController::class, 'store'])->name('admin.productos.store')->middleware('auth');
Route::get('/admin/productos/{id}/show', [ProductoController::class, 'show'])->name('admin.productos.show')->middleware('auth');
Route::get('/admin/productos/{id}/edit', [ProductoController::class, 'edit'])->name('admin.productos.edit')->middleware('auth');
Route::put('/admin/productos/{id}', [ProductoController::class, 'update'])->name('admin.productos.update')->middleware('auth');
Route::delete('/admin/productos/{id}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy')->middleware('auth');
Route::get('productos/restaurar/{id}', [ProductoController::class, 'restaurar'])->name('admin.productos.restaurar')->middleware('auth');

//Proveedores
Route::get('/admin/proveedores', [ProveedorController::class, 'index'])->name('admin.proveedores.index')->middleware('auth');
Route::get('/admin/proveedores/create', [ProveedorController::class, 'create'])->name('admin.proveedores.create')->middleware('auth');
Route::post('/admin/proveedores', [ProveedorController::class, 'store'])->name('admin.proveedores.store')->middleware('auth');
Route::get('/admin/proveedores/{id}', [ProveedorController::class, 'show'])->name('admin.proveedores.show')->middleware('auth');
Route::get('/admin/proveedores/{id}/edit', [ProveedorController::class, 'edit'])->name('admin.proveedores.edit')->middleware('auth');
Route::put('/admin/proveedores/{id}', [ProveedorController::class, 'update'])->name('admin.proveedores.update')->middleware('auth');
Route::delete('/admin/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('admin.proveedores.destroy')->middleware('auth');
Route::get('proveedores/restaurar/{id}', [ProveedorController::class, 'restaurar'])->name('admin.proveedores.restaurar')->middleware('auth');

//Compras
Route::get('/admin/compras', [CompraController::class, 'index'])->name('admin.compras.index')->middleware('auth');
Route::get('/admin/compras/create', [CompraController::class, 'create'])->name('admin.compras.create')->middleware('auth');
Route::post('/admin/compras', [CompraController::class, 'store'])->name('admin.compras.store')->middleware('auth');
Route::get('/admin/compras/{id}', [CompraController::class, 'show'])->name('admin.compras.show')->middleware('auth');
Route::get('/admin/compras/{id}/edit', [CompraController::class, 'edit'])->name('admin.compras.edit')->middleware('auth');
Route::put('/admin/compras/{id}', [CompraController::class, 'update'])->name('admin.compras.update')->middleware('auth');
Route::put('/admin/compras/{id}/anular', [CompraController::class, 'anular'])->name('admin.compras.anular')->middleware('auth');

//TPM compras
Route::post('/admin/compras/create/tmp', [TmpCompraController::class, 'tmp_compras'])->name('admin.compras.tmp_compras')->middleware('auth');
Route::delete('/admin/compras/create/tmp/{id}', [TmpCompraController::class, 'destroy'])->name('admin.compras.tmp_compras.destroy')->middleware('auth');
Route::post('/admin/compras/actualizar-precio', [TmpCompraController::class, 'actualizarPrecio'])->name('admin.compras.tmp_compras.actualizarPrecio')->middleware('auth');
