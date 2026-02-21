<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\RoleController;
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
