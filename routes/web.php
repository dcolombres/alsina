<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\BiYAnaliticaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/gestion', [GestionController::class, 'index'])->name('gestion.index');

    Route::get('/proyectos/{proyecto}/pdf', [ProyectoController::class, 'pdf'])->name('proyectos.pdf');
    Route::resource('proyectos', ProyectoController::class);
    Route::get('/staff/{staff}/pdf', [StaffController::class, 'pdf'])->name('staff.pdf');
    Route::resource('staff', StaffController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('bi_y_analitica', BiYAnaliticaController::class);
});

require __DIR__.'/auth.php';
