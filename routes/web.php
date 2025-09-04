<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/test', [ProfileController::class, 'test']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/instituciones', [InstitucionController::class, 'index'])->name('instituciones.index');
    Route::get('/instituciones/create', [InstitucionController::class, 'create'])->name('instituciones.create');
    Route::post('/instituciones', [InstitucionController::class, 'store'])->name('instituciones.store');
    Route::get('/instituciones/{id}/edit', [InstitucionController::class, 'edit'])->name('instituciones.edit');
    Route::put('/instituciones/{id}', [InstitucionController::class, 'update'])->name('instituciones.update');
    Route::delete('/instituciones/{id}', [InstitucionController::class, 'destroy'])->name('instituciones.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');
    Route::get('/departamentos/create', [DepartamentoController::class, 'create'])->name('departamentos.create');
    Route::post('/departamentos', [DepartamentoController::class, 'store'])->name('departamentos.store');
    Route::get('/departamentos/{id}/edit', [DepartamentoController::class, 'edit'])->name('departamentos.edit');
    Route::put('/departamentos/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
    Route::delete('/departamentos/{id}', [DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/servidores', [ServidorController::class, 'index'])->name('servidores.index');
    Route::get('/servidores/create', [ServidorController::class, 'create'])->name('servidores.create');
    Route::post('/servidores', [ServidorController::class, 'store'])->name('servidores.store');
    Route::get('/servidores/{id}/edit', [ServidorController::class, 'edit'])->name('servidores.edit');
    Route::put('/servidores/{id}', [ServidorController::class, 'update'])->name('servidores.update');
    Route::delete('/servidores/{id}', [ServidorController::class, 'destroy'])->name('servidores.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
    Route::get('/expedientes/create', [ExpedienteController::class, 'create'])->name('expedientes.create');
    Route::post('/expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');
    Route::get('/expedientes/{id}/edit', [ExpedienteController::class, 'edit'])->name('expedientes.edit');
    Route::put('/expedientes/{id}', [ExpedienteController::class, 'update'])->name('expedientes.update');
    Route::delete('/expedientes/{id}', [ExpedienteController::class, 'destroy'])->name('expedientes.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/controles', [ControlController::class, 'index'])->name('controles.index');
    Route::get('/controles/create', [ControlController::class, 'create'])->name('controles.create');
    Route::post('/controles', [ControlController::class, 'store'])->name('controles.store');
    Route::get('/controles/{id}/edit', [ControlController::class, 'edit'])->name('controles.edit');
    Route::put('/controles/{id}', [ControlController::class, 'update'])->name('controles.update');
    Route::delete('/controles/{id}', [ControlController::class, 'destroy'])->name('controles.destroy');
});

require __DIR__.'/auth.php';
