<?php

use Illuminate\Support\Facades\Route;

Route::resource('/', \App\Http\Controllers\TasksController::class)->middleware('auth')->only('index');

Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'store']);
Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
