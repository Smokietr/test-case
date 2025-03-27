<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('/tasks', \App\Http\Controllers\TasksController::class)->except('index', 'show', 'edit', 'create');
