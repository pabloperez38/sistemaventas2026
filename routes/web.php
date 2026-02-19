<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [AdminController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [AdminController::class, 'index'])->name('home')->middleware('auth');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');
