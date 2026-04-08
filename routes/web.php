<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TmpCompraController;
use App\Http\Controllers\TmpVentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('admin.index');
    });

    Route::get('/home', function () {
        return redirect()->route('admin.index');
    });

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');
});

//Configuración
Route::get('/admin/configuracion', [ConfiguracionController::class, 'index'])->name('admin.configuracion.index')->middleware('auth', 'can:Ver Configuración');
Route::put('/admin/configuracion', [ConfiguracionController::class, 'update'])->name('admin.configuracion.update')->middleware('auth', 'can:Editar Configuración');

//Roles
Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth', 'can:Ver Roles');
Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth', 'can:Formulario Crear Roles');
Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth', 'can:Guardar Roles');
Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth', 'can:Formulario Editar Roles');
Route::get('/admin/roles/{role}/permisos', [RoleController::class, 'permisos'])->name('admin.roles.permisos')->middleware('auth', 'can:Formulario Permisos Roles');
Route::put('/admin/roles/{role}/update_permisos', [RoleController::class, 'update_permisos'])->name('admin.roles.update_permisos')->middleware('auth', 'can:Actualizar Permisos Roles');
Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth', 'can:Editar Roles');
Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth', 'can:Eliminar Roles');

//Usuarios
Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth', 'can:Ver Usuarios');
Route::get('/admin/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth', 'can:Formulario Crear Usuarios');
Route::post('/admin/usuarios', [UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth', 'can:Guardar Usuarios');
Route::get('/admin/usuarios/{id}', [UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth', 'can:Ver Detalles Usuarios');
Route::get('/admin/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth', 'can:Formulario Editar Usuarios');
Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth', 'can:Editar Usuarios');
Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth', 'can:Eliminar Usuarios');

//Categorias
Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias.index')->middleware('auth', 'can:Ver Categorías');
Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create')->middleware('auth', 'can:Formulario Crear Categorías');
Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store')->middleware('auth', 'can:Guardar Categorías');
Route::get('/admin/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('admin.categorias.edit')->middleware('auth', 'can:Formulario Editar Categorías');
Route::put('/admin/categorias/{id}', [CategoriaController::class, 'update'])->name('admin.categorias.update')->middleware('auth', 'can:Editar Categorías');
Route::delete('/admin/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy')->middleware('auth', 'can:Eliminar Categorías');
Route::get('categorias/{id}/restore', [CategoriaController::class, 'restore'])->name('admin.categorias.restore')->middleware('auth', 'can:Restaurar Categorías');

//Marcas
Route::get('/admin/marcas', [MarcaController::class, 'index'])->name('admin.marcas.index')->middleware('auth', 'can:Ver Marcas');
Route::get('/admin/marcas/create', [MarcaController::class, 'create'])->name('admin.marcas.create')->middleware('auth', 'can:Formulario Crear Marcas');
Route::post('/admin/marcas', [MarcaController::class, 'store'])->name('admin.marcas.store')->middleware('auth', 'can:Guardar Marcas');
Route::get('/admin/marcas/{id}/edit', [MarcaController::class, 'edit'])->name('admin.marcas.edit')->middleware('auth', 'can:Formulario Editar Marcas');
Route::put('/admin/marcas/{id}', [MarcaController::class, 'update'])->name('admin.marcas.update')->middleware('auth', 'can:Editar Marcas');
Route::delete('/admin/marcas/{id}', [MarcaController::class, 'destroy'])->name('admin.marcas.destroy')->middleware('auth', 'can:Eliminar Marcas');
Route::get('marcas/{id}/restore', [MarcaController::class, 'restore'])->name('admin.marcas.restore')->middleware('auth', 'can:Restaurar Marcas');


//Productos
Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos.index')->middleware('auth', 'can:Ver Productos');
Route::get('/admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create')->middleware('auth', 'can:Formulario Crear Productos');
Route::post('/admin/productos', [ProductoController::class, 'store'])->name('admin.productos.store')->middleware('auth', 'can:Guardar Productos');
Route::get('/admin/productos/{id}/show', [ProductoController::class, 'show'])->name('admin.productos.show')->middleware('auth', 'can:Ver Detalles Productos');
Route::get('/admin/productos/{id}/edit', [ProductoController::class, 'edit'])->name('admin.productos.edit')->middleware('auth', 'can:Formulario Editar Productos');
Route::put('/admin/productos/{id}', [ProductoController::class, 'update'])->name('admin.productos.update')->middleware('auth', 'can:Editar Productos');
Route::delete('/admin/productos/{id}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy')->middleware('auth', 'can:Eliminar Productos');
Route::get('productos/restaurar/{id}', [ProductoController::class, 'restaurar'])->name('admin.productos.restaurar')->middleware('auth', 'can:Restaurar Productos');
Route::get('/admin/productos/update-price', [ProductoController::class, 'updatePrice'])->name('admin.productos.updatePrice')->middleware('auth', 'can:Actualizar Precios Productos');
Route::post('productos/actualizar-precios', [ProductoController::class, 'actualizarPrecios'])->name('admin.productos.actualizarPrecios')->middleware('auth', 'can:Acción Actualizar Precios Productos');

//Proveedores
Route::get('/admin/proveedores', [ProveedorController::class, 'index'])->name('admin.proveedores.index')->middleware('auth', 'can:Ver Proveedores');
Route::get('/admin/proveedores/create', [ProveedorController::class, 'create'])->name('admin.proveedores.create')->middleware('auth', 'can:Formulario Crear Proveedores');
Route::post('/admin/proveedores', [ProveedorController::class, 'store'])->name('admin.proveedores.store')->middleware('auth', 'can:Guardar Proveedores');
Route::get('/admin/proveedores/{id}', [ProveedorController::class, 'show'])->name('admin.proveedores.show')->middleware('auth', 'can:Ver Detalles Proveedores');
Route::get('/admin/proveedores/{id}/edit', [ProveedorController::class, 'edit'])->name('admin.proveedores.edit')->middleware('auth', 'can:Formulario Editar Proveedores');
Route::put('/admin/proveedores/{id}', [ProveedorController::class, 'update'])->name('admin.proveedores.update')->middleware('auth', 'can:Editar Proveedores');
Route::delete('/admin/proveedores/{id}', [ProveedorController::class, 'destroy'])->name('admin.proveedores.destroy')->middleware('auth', 'can:Eliminar Proveedores');
Route::get('proveedores/restaurar/{id}', [ProveedorController::class, 'restaurar'])->name('admin.proveedores.restaurar')->middleware('auth', 'can:Restaurar Proveedores');

//Compras
Route::get('/admin/compras', [CompraController::class, 'index'])->name('admin.compras.index')->middleware('auth', 'can:Ver Compras');
Route::get('/admin/compras/create', [CompraController::class, 'create'])->name('admin.compras.create')->middleware('auth', 'can:Formulario Crear Compras');
Route::post('/admin/compras', [CompraController::class, 'store'])->name('admin.compras.store')->middleware('auth', 'can:Guardar Compras');
Route::get('/admin/compras/{id}', [CompraController::class, 'show'])->name('admin.compras.show')->middleware('auth', 'can:Ver Detalles Compras');
Route::put('/admin/compras/{id}/anular', [CompraController::class, 'anular'])->name('admin.compras.anular')->middleware('auth', 'can:Anular Compras');

//TPM compras
Route::post('/admin/compras/create/tmp', [TmpCompraController::class, 'tmp_compras'])->name('admin.compras.tmp_compras')->middleware('auth');
Route::delete('/admin/compras/create/tmp/{id}', [TmpCompraController::class, 'destroy'])->name('admin.compras.tmp_compras.destroy')->middleware('auth');
Route::post('/admin/compras/actualizar-precio', [TmpCompraController::class, 'actualizarPrecio'])->name('admin.compras.tmp_compras.actualizarPrecio')->middleware('auth');

//Clientes
Route::get('/admin/clientes', [ClienteController::class, 'index'])->name('admin.clientes.index')->middleware('auth', 'can:Ver Clientes');
Route::get('/admin/clientes/create', [ClienteController::class, 'create'])->name('admin.clientes.create')->middleware('auth', 'can:Formulario Crear Clientes');
Route::post('/admin/clientes', [ClienteController::class, 'store'])->name('admin.clientes.store')->middleware('auth', 'can:Guardar Clientes');
Route::get('/admin/clientes/{id}', [ClienteController::class, 'show'])->name('admin.clientes.show')->middleware('auth', 'can:Ver Detalles Clientes');
Route::get('/admin/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('admin.clientes.edit')->middleware('auth', 'can:Formulario Editar Clientes');
Route::put('/admin/clientes/{id}', [ClienteController::class, 'update'])->name('admin.clientes.update')->middleware('auth', 'can:Editar Clientes');
Route::delete('/admin/clientes/{id}', [ClienteController::class, 'destroy'])->name('admin.clientes.destroy')->middleware('auth', 'can:Eliminar Clientes');
Route::get('clientes/restaurar/{id}', [ClienteController::class, 'restaurar'])->name('admin.clientes.restaurar')->middleware('auth', 'can:Restaurar Clientes');

//Ventas
Route::get('/admin/ventas', [VentaController::class, 'index'])->name('admin.ventas.index')->middleware('auth', 'can:Ver Ventas');
Route::get('/admin/ventas/create', [VentaController::class, 'create'])->name('admin.ventas.create')->middleware('auth', 'can:Formulario Crear Ventas');
Route::post('/admin/ventas', [VentaController::class, 'store'])->name('admin.ventas.store')->middleware('auth', 'can:Guardar Ventas');
Route::get('/admin/ventas/{id}', [VentaController::class, 'show'])->name('admin.ventas.show')->middleware('auth', 'can:Ver Detalles Ventas');
Route::get('/admin/ventas/pdf/{id}', [VentaController::class, 'pdf'])->name('admin.ventas.pdf')->middleware('auth', 'can:Imprimir Ventas');
Route::put('/admin/ventas/{id}/anular', [VentaController::class, 'anular'])->name('admin.ventas.anular')->middleware('auth', 'can:Anular Ventas');

//TPM ventas
Route::post('/admin/ventas/create/tmp', [TmpVentaController::class, 'tmp_ventas'])->name('admin.ventas.tmp_ventas')->middleware('auth');
Route::delete('/admin/ventas/create/tmp/{id}', [TmpVentaController::class, 'destroy'])->name('admin.ventas.tmp_ventas.destroy')->middleware('auth');
Route::post('/admin/ventas/actualizar-precio', [TmpVentaController::class, 'actualizarPrecio'])->name('admin.ventas.tmp_ventas.actualizarPrecio')->middleware('auth');

//Cajas
Route::get('/admin/cajas', [CajaController::class, 'index'])->name('admin.cajas.index')->middleware('auth', 'can:Ver Cajas');
Route::get('/admin/cajas/create', [CajaController::class, 'create'])->name('admin.cajas.create')->middleware('auth', 'can:Formulario Crear Cajas');
Route::post('/admin/cajas', [CajaController::class, 'store'])->name('admin.cajas.store')->middleware('auth', 'can:Guardar Cajas');
Route::get('/admin/cajas/{id}', [CajaController::class, 'show'])->name('admin.cajas.show')->middleware('auth', 'can:Ver Detalles Cajas');
Route::get('/admin/cajas/{id}/edit', [CajaController::class, 'edit'])->name('admin.cajas.edit')->middleware('auth', 'can:Formulario Editar Cajas');
Route::put('/admin/cajas/{id}', [CajaController::class, 'update'])->name('admin.cajas.update')->middleware('auth', 'can:Editar Cajas');
Route::get('/admin/cajas/{id}/ingreso-egreso', [CajaController::class, 'ingresoegreso'])->name('admin.cajas.ingreso-egreso')->middleware('auth', 'can:Formulario Ingreso/Egreso Cajas');
Route::post('/admin/cajas/{id}/ingreso-egreso', [CajaController::class, 'store_ingresos_egresos'])->name('admin.cajas.store_ingresos_egresos')->middleware('auth', 'can:Guardar Ingreso/Egreso Cajas');
Route::get('/admin/cajas/{id}/cerrar', [CajaController::class, 'cerrar'])->name('admin.cajas.cerrar')->middleware('auth', 'can:Formulario Cierre Cajas');
Route::post('/admin/cajas/{id}/cierre', [CajaController::class, 'store_cierre'])->name('admin.cajas.store_cierre')->middleware('auth', 'can:Guardar Cierre Cajas');

//Backups
Route::get('/admin/backups', [BackupController::class, 'index'])->name('admin.backups.index')->middleware('auth', 'can:Ver Listado de Backups');
Route::post('/admin/backups/create', [BackupController::class, 'store'])->name('admin.backups.store')->middleware('auth', 'can:Crear Backups');
Route::get('/admin/backups/{file}/download', [BackupController::class, 'download'])->name('admin.backups.download')->middleware('auth', 'can:Descargar Backups');
Route::delete('/admin/backups/{file}/delete', [BackupController::class, 'destroy'])->name('admin.backups.destroy')->middleware('auth', 'can:Eliminar Backups');

//Tiketera
Route::get('/admin/test-ticket', [VentaController::class, 'testTicket'])->name('admin.test-ticket')->middleware('auth');
