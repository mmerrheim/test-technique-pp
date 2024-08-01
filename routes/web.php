<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/movie');

Route::middleware(['auth', 'verified'])->group(function () {
  
    Route::resource('user', UserController::class);
    Route::resource('movie', MovieController::class);
});

Route::middleware('auth')->group(function () {
});

require __DIR__ . '/auth.php';
